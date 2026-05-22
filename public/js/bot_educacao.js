// ============================================================
//  BASE DE CONHECIMENTO — Edite aqui para personalizar o bot
// ============================================================
const KNOWLEDGE_BASE = `
Você é o assistente virtual oficial da Secretaria Municipal de Educação de Mangaratiba.
Responda sempre em português, de forma clara, amigável e objetiva.
Use emojis moderadamente para deixar o texto mais amigável.

=== INFORMAÇÕES GERAIS ===
- Horário de atendimento presencial: Segunda a Sexta, das 8h às 17h
- Endereço: Praça Robert Simões, nº 92 – Centro – Mangaratiba/RJ
- Telefone: (21) 2789-6000 (Ramal Educação: 280)
- E-mail: atendimento@sme.mangaratiba.rj.gov.br
- Site oficial: educacao.mangaratiba.rj.gov.br

=== MATRÍCULAS ===
- O período de matrículas para o ano letivo de 2025 é de 01/02/2025 a 28/02/2025.
- Pré-matrícula online disponível no portal ou pelo chatbot.
- Documentos necessários: RG e CPF do responsável, certidão de nascimento do aluno,
  comprovante de residência (últimos 3 meses), carteira de vacinação (até 6 anos),
  histórico escolar ou declaração da escola anterior.
- Alunos com necessidades especiais devem apresentar laudo médico atualizado.
- Vagas garantidas para alunos já matriculados na rede mediante rematrícula até 20/01/2025.
- Não há taxa para realização de matrículas.

=== REMATRÍCULA ===
- Prazo de rematrícula: 01/01/2025 a 20/01/2025.
- Realizada diretamente na escola onde o aluno já estuda.
- Documentos: apenas atualização de dados se necessário.

=== SITUAÇÃO DA INSCRIÇÃO ===
- Para consultar, informe o número do protocolo ou o CPF do responsável.
- O prazo para análise das inscrições é de até 10 dias úteis após o envio.
- Status possíveis: Em Análise, Aprovada, Aguardando Documentos, Indeferida.
- Em caso de indeferimento, o responsável tem 5 dias úteis para recurso.

=== TRANSFERÊNCIA ===
- Solicitações de transferência entre escolas da rede: na escola de destino.
- Transferência de outra rede: trazer histórico escolar e documentos pessoais.
- Não há custo para transferência.

=== TRANSPORTE ESCOLAR ===
- Gratuito para alunos que moram a mais de 2km da escola.
- Inscrição: na própria escola ou no portal da secretaria.
- Rotas disponíveis no site oficial.

=== ALIMENTAÇÃO ESCOLAR ===
- Merenda escolar gratuita para todos os alunos da rede.
- Cardápio semanal publicado no site.
- Alunos com restrições alimentares: informar à direção da escola com laudo médico.

=== BOLSA FAMÍLIA / FREQUÊNCIA ===
- A secretaria informa frequência escolar ao Ministério da Cidadania mensalmente.
- Frequência mínima exigida: 75% das aulas.
- Em caso de dúvida, contate a escola diretamente.


=== CALENDÁRIO ESCOLAR 2025 ===
- Início das aulas: 10/02/2025
- Recesso de Carnaval: 03/03/2025 a 05/03/2025
- Recesso de Julho: 07/07/2025 a 18/07/2025
- Término do ano letivo: 19/12/2025
- Total de dias letivos: 200 dias.

=== CONTATO PARA DENÚNCIAS ===
- Ouvidoria: 0800-123-4567 (gratuito, 24h)
- E-mail: ouvidoria@sme.mangaratiba.rj.gov.br

=== REGRAS DE CONDUTA DO ASSISTENTE ===
- Se não souber a resposta, oriente o usuário a ligar para (21) 2789-6000 ou ir ao atendimento presencial.
- Não invente informações que não estejam na base de conhecimento acima.
- Se a pergunta for sobre algo muito específico (escola X, professor Y), oriente a contatar a escola diretamente.
- Seja sempre educado e empático.
`;

// ============================================================
//  FLUXO INICIAL ESTRUTURADO
// ============================================================
let userData = { nome: '', servico: '', protocolo: '' };
let currentIndex = 0;
let chatHistory = [];
let flowComplete = false;

const botFlow = [
  {
    question: "Olá! Sou o assistente virtual da Secretaria de Educação 👋\n\nPara começarmos, qual o seu nome?",
    field: "nome"
  },
  {
    question: (d) => `Prazer, ${d.nome}! Como posso te ajudar hoje? 😊`,
    field: "servico",
    options: ["Fazer Nova Matrícula", "Ver Situação da Inscrição", "Tenho uma dúvida"]
  },
  {
    question: "Por favor, digite o número do seu protocolo ou o seu CPF para consulta:",
    field: "protocolo",
    condition: (d) => d.servico === "Ver Situação da Inscrição"
  }
];

// ============================================================
//  INICIALIZAÇÃO
// ============================================================
document.addEventListener('DOMContentLoaded', createChatWidget);

function resetChat() {
  userData = { nome: '', servico: '', protocolo: '' };
  currentIndex = 0;
  chatHistory = [];
  flowComplete = false;

  const cw = document.getElementById('chat-window');
  cw.innerHTML = '';
  document.getElementById('options-container').classList.add('hidden');
  document.getElementById('options-container').innerHTML = '';
  const inp = document.getElementById('user-input');
  inp.disabled = false;
  inp.value = '';
  inp.placeholder = 'Digite sua resposta...';
  document.getElementById('send-btn').disabled = false;
  addMessage(botFlow[0].question);
}

// ============================================================
//  WIDGET HTML
// ============================================================
function createChatWidget() {
  const launcher = document.createElement('button');
  launcher.id = 'chat-launcher';
  launcher.className = 'fixed bottom-6 right-6 z-[1000] bg-blue-600 text-white p-4 rounded-full shadow-2xl hover:bg-blue-700 hover:scale-110 active:scale-95 transition-all duration-300 flex items-center justify-center cursor-pointer';
  launcher.innerHTML = `
    <svg id="chat-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
    <svg id="close-icon" class="w-8 h-8 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>`;

  const popup = document.createElement('div');
  popup.id = 'chat-popup';
  popup.className = 'fixed bottom-24 right-6 z-[1000] w-[90vw] md:w-[400px] h-[550px] bg-white rounded-2xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden opacity-0 translate-y-4 pointer-events-none transition-all duration-300';
  popup.innerHTML = `
    <div class="bg-blue-600 p-4 text-white font-bold flex justify-between items-center shrink-0">
      <div class="flex items-center gap-2">
        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
        <span class="text-sm">Secretaria de Educação IA</span>
      </div>
      <button onclick="resetChat()" class="text-xs bg-white/20 hover:bg-white/30 px-2 py-1 rounded transition">Reiniciar</button>
    </div>
    <div id="chat-window" class="flex-1 overflow-y-auto p-4 space-y-1 bg-gray-50 flex flex-col scroll-smooth"></div>
    <div id="options-container" class="px-4 pb-2 flex flex-wrap gap-2 bg-gray-50 hidden"></div>
    <div class="p-4 border-t flex gap-2 bg-white shrink-0">
      <input type="text" id="user-input" placeholder="Digite sua resposta..."
        class="flex-1 border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
      <button id="send-btn" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
        </svg>
      </button>
    </div>`;

  document.body.appendChild(launcher);
  document.body.appendChild(popup);

  launcher.onclick = () => {
    const isOpen = !popup.classList.contains('opacity-0');
    if (isOpen) {
      popup.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
      document.getElementById('chat-icon').classList.remove('hidden');
      document.getElementById('close-icon').classList.add('hidden');
    } else {
      popup.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
      document.getElementById('chat-icon').classList.add('hidden');
      document.getElementById('close-icon').classList.remove('hidden');
      document.getElementById('user-input').focus();
    }
  };

  const inp = popup.querySelector('#user-input');
  const btn = popup.querySelector('#send-btn');
  btn.onclick = () => handleInput(inp.value);
  inp.onkeypress = (e) => { if (e.key === 'Enter') handleInput(inp.value); };

  addMessage(botFlow[0].question);
}

// ============================================================
//  MENSAGENS
// ============================================================
function addMessage(text, isUser = false) {
  const cw = document.getElementById('chat-window');
  const msg = document.createElement('div');
  msg.className = `msg-in mb-2 p-3 rounded-xl text-sm max-w-[85%] ${isUser
    ? 'bg-blue-600 text-white self-end shadow-md'
    : 'bg-white text-gray-800 self-start shadow-sm border border-gray-100'}`;
  msg.innerHTML = text.replace(/\n/g, '<br>');
  cw.appendChild(msg);
  cw.scrollTop = cw.scrollHeight;
  return msg;
}

function showTyping() {
  const cw = document.getElementById('chat-window');
  const el = document.createElement('div');
  el.id = 'typing-indicator';
  el.className = 'msg-in mb-2 p-3 rounded-xl text-sm max-w-[85%] bg-white self-start shadow-sm border border-gray-100 flex gap-1 items-center';
  el.innerHTML = `<span class="typing-dot w-2 h-2 bg-gray-400 rounded-full inline-block"></span>
                  <span class="typing-dot w-2 h-2 bg-gray-400 rounded-full inline-block"></span>
                  <span class="typing-dot w-2 h-2 bg-gray-400 rounded-full inline-block"></span>`;
  cw.appendChild(el);
  cw.scrollTop = cw.scrollHeight;
}

function removeTyping() {
  document.getElementById('typing-indicator')?.remove();
}

function showOptions(options) {
  const c = document.getElementById('options-container');
  c.innerHTML = '';
  c.classList.remove('hidden');
  options.forEach(opt => {
    const btn = document.createElement('button');
    btn.className = 'bg-white border border-blue-500 text-blue-600 px-3 py-1 rounded-full text-xs font-medium hover:bg-blue-600 hover:text-white transition cursor-pointer';
    btn.innerText = opt;
    btn.onclick = () => { c.classList.add('hidden'); handleInput(opt); };
    c.appendChild(btn);
  });
}

function addActionButton(label, href, color = 'green') {
  const cw = document.getElementById('chat-window');
  const a = document.createElement('a');
  a.href = href;
  if (href.startsWith('http')) a.target = '_blank';
  a.className = `msg-in block self-start mb-2 bg-${color}-500 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-${color}-600 transition text-center no-underline`;
  a.innerText = label;
  cw.appendChild(a);
  cw.scrollTop = cw.scrollHeight;
}

// ============================================================
//  ENTRADA DO USUÁRIO
// ============================================================
function handleInput(val) {
  val = val.trim();
  if (!val) return;
  document.getElementById('user-input').value = '';
  addMessage(val, true);

  if (flowComplete) {
    askAI(val);
  } else {
    processFlowAnswer(val);
  }
}

// ============================================================
//  FLUXO ESTRUTURADO
// ============================================================
function processFlowAnswer(answer) {
  if (currentIndex >= botFlow.length) {
    askAI(answer);
    return;
  }

  const step = botFlow[currentIndex];
  userData[step.field] = answer;
  currentIndex++;

  setTimeout(async () => {
    while (currentIndex < botFlow.length) {
      const next = botFlow[currentIndex];
      if (!next.condition || next.condition(userData)) break;
      currentIndex++;
    }

    if (currentIndex < botFlow.length) {
      const next = botFlow[currentIndex];
      const q = typeof next.question === 'function' ? next.question(userData) : next.question;
      showTyping();
      await delay(600);
      removeTyping();
      addMessage(q);
      if (next.options) showOptions(next.options);
    } else {
      handleFinalFlowStep();
    }
  }, 500);
}

async function handleFinalFlowStep() {
  if (userData.servico === "Fazer Nova Matrícula") {
    showTyping();
    await delay(700);
    removeTyping();
    addMessage(`Ótimo, ${userData.nome}! Você pode fazer sua pré-matrícula clicando abaixo 👇`);
    addActionButton('📝 Fazer Inscrição Agora', '/api/register');
    endFlowOpenChat("Ficou com alguma dúvida sobre documentos, prazos ou outras informações? É só perguntar!");

  } else if (userData.servico === "Ver Situação da Inscrição") {
    if (!userData.protocolo) {
        currentIndex = 2;
        addMessage(botFlow[2].question);
        return;
    }

    showTyping();
    await delay(500);
    removeTyping();
    addMessage("Buscando informações da sua inscrição... 🔍");
    showTyping();

    try {
      const res = await fetch(`/api/matricula/status/${encodeURIComponent(userData.protocolo.trim())}`);
      if (!res.ok) throw new Error();
      const json = await res.json();
      removeTyping();

      if (json.success) {
        const d = json.data;
        addMessage(`<b>Inscrição Encontrada! ✅</b><br>👤 Aluno: ${d.nome}<br>📑 Protocolo: ${d.protocolo}<br>🏫 Escola: ${d.escola}<br>📅 Ano: ${d.ano_letivo}<br>Status: <b>${d.status}</b>`);
        const txt = `Olá! Sou ${userData.nome}. Consultei minha inscrição (${userData.protocolo}) e gostaria de mais informações.`;
        addActionButton('💬 Falar no WhatsApp', `https://api.whatsapp.com/send?phone=552127896000&text=${encodeURIComponent(txt)}`);
      } else {
        addMessage(`❌ Dados não encontrados para <b>${userData.protocolo}</b>. Verifique o protocolo ou CPF e tente novamente.`);
        currentIndex = 2;
        await delay(800);
        addMessage(botFlow[2].question);
        return;
      }
    } catch {
      removeTyping();
      addMessage(`❌ Erro ao buscar dados. Verifique se digitou o protocolo ou CPF corretamente.`);
      currentIndex = 2;
      await delay(800);
      addMessage(botFlow[2].question);
      return;
    }

    endFlowOpenChat("Posso ajudar com mais alguma coisa?");

  } else {
    // Caso o usuário digite algo que não é uma das opções ou selecione "Tenho uma dúvida"
    showTyping();
    await delay(600);
    removeTyping();
    endFlowOpenChat(`Claro, ${userData.nome}! Pode perguntar — estou aqui para ajudar! 😊`);
  }
}

function endFlowOpenChat(msg) {
  flowComplete = true;
  addMessage(msg);

  chatHistory = [
    { role: "user", content: `Meu nome é ${userData.nome}.` },
    { role: "assistant", content: `Olá, ${userData.nome}! Como posso ajudar?` }
  ];

  const inp = document.getElementById('user-input');
  inp.placeholder = 'Faça sua pergunta...';
}

// ============================================================
//  MOTOR DE BUSCA LOCAL (100% GRATUITO)
// ============================================================
function normalizeText(text) {
  return text.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().trim();
}

function getLocalResponse(userMessage) {
  // Regex para extrair seções no formato: === TITULO === CONTEUDO
  const sectionRegex = /===\s*(.*?)\s*===([\s\S]*?)(?====|$)/g;
  const normalizedQuery = normalizeText(userMessage);
  const keywords = normalizedQuery.split(/\s+/).filter(w => w.length > 3);

  let bestMatch = null;
  let highestScore = 0;
  let match;

  while ((match = sectionRegex.exec(KNOWLEDGE_BASE)) !== null) {
    const title = match[1].trim();
    const content = match[2].trim();

    const normalizedTitle = normalizeText(title);
    const normalizedContent = normalizeText(content);

    let score = 0;

    // Pontuação por título (similaridade exata ou parcial)
    if (normalizedTitle.includes(normalizedQuery) || normalizedQuery.includes(normalizedTitle)) {
      score += 20; // Aumentei o peso do título
    }

    // Pontuação por palavras-chave
    keywords.forEach(word => {
      // Se a palavra está no título, vale muito
      if (normalizedTitle.includes(word)) score += 10;
      // Se a palavra está no conteúdo, vale um pouco
      if (normalizedContent.includes(word)) score += 4;
    });

    if (score > highestScore) {
      highestScore = score;
      bestMatch = { title, text: content };
    }
  }

  if (highestScore > 3) {
    return `<b>${bestMatch.title}</b><br><br>${bestMatch.text.replace(/\n/g, '<br>')}`;
  }

  return "Desculpe, não encontrei uma informação específica sobre isso na minha base de dados. Você pode tentar perguntar de outra forma (ex: 'matricula', 'documentos', 'calendario') ou ligar para (21) 2789-6000.";
}

// ============================================================
//  PROCESSAMENTO DE DÚVIDAS
// ============================================================
async function askAI(userMessage) {
  showTyping();
  document.getElementById('user-input').disabled = true;

  await delay(1000); // Simula tempo de resposta para ficar natural

  const reply = getLocalResponse(userMessage);

  removeTyping();
  addMessage(reply);

  document.getElementById('user-input').disabled = false;
  document.getElementById('user-input').focus();
}

// ============================================================
//  UTIL
// ============================================================
function delay(ms) { return new Promise(r => setTimeout(r, ms)); }
