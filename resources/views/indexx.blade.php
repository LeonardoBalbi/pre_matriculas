<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Pre Matricula</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('partials.pwa')
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.cdnfonts.com/css/general-sans?styles=135312,135310,135313,135303" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/tailwind/tailwind.min.css">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link rel="icon" type="image/png" sizes="32x32" href="shuffle-for-tailwind.png">
    <script src="js/main.js"></script>
    <script>
        // Checa a cada 2 segundos se o modo manutenção foi ativado
        setInterval(async function() {
            try {
                const resp = await fetch('/manutencao-status');
                const data = await resp.json();
                if (data.ativo) {
                    window.location.href = '/manutencao';
                }
            } catch (e) {}
        }, 2000);
    </script>
</head>
<body class="antialiased bg-body text-body font-body">


        <!-- menu -->
        <!-- menu -->

        <div class=" ">

          <section class="overflow-hidden ">
            <div>
              <div class="px-8   xl:py-1  fixed  w-full z-50 bg-gray-900 border-b border-coolGray-600 ">
                <div class="flex items-center justify-between -m-2">
                  <div class="flex flex-wrap items-center w-auto p-2">
                    <a class="block max-w-max -ml-4 " href="#">


                                              <!-- logo  -->

                      <img src="img/seduc-white.png" onerror="this.src='img/smeel-branco2.png'" class="p-5" alt="Secretaria de Educação">
                    </a>
                    <ul class="hidden xl:flex flex-wrap ">
                      <li class="mr-8">
                        <a class="flex flex-wrap items-center py-8 text-base font-medium text-coolGray-500 hover:text-blue-500 border-b-2 border-transparent hover:border-blue-500" href="#Etapas">
                          <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 6C11.7348 6 11.4804 6.10536 11.2929 6.29289C11.1054 6.48043 11 6.73478 11 7V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8946 17.5196 13 17.2652 13 17V7C13 6.73478 12.8946 6.48043 12.7071 6.29289C12.5196 6.10536 12.2652 6 12 6ZM7 12C6.73478 12 6.48043 12.1054 6.29289 12.2929C6.10536 12.4804 6 12.7348 6 13V17C6 17.2652 6.10536 17.5196 6.29289 17.7071C6.48043 17.8946 6.73478 18 7 18C7.26522 18 7.51957 17.8946 7.70711 17.7071C7.89464 17.5196 8 17.2652 8 17V13C8 12.7348 7.89464 12.4804 7.70711 12.2929C7.51957 12.1054 7.26522 12 7 12ZM17 10C16.7348 10 16.4804 10.1054 16.2929 10.2929C16.1054 10.4804 16 10.7348 16 11V17C16 17.2652 16.1054 17.5196 16.2929 17.7071C16.4804 17.8946 16.7348 18 17 18C17.2652 18 17.5196 17.8946 17.7071 17.7071C17.8946 17.5196 18 17.2652 18 17V11C18 10.7348 17.8946 10.4804 17.7071 10.2929C17.5196 10.1054 17.2652 10 17 10ZM19 2H5C4.20435 2 3.44129 2.31607 2.87868 2.87868C2.31607 3.44129 2 4.20435 2 5V19C2 19.7956 2.31607 20.5587 2.87868 21.1213C3.44129 21.6839 4.20435 22 5 22H19C19.7956 22 20.5587 21.6839 21.1213 21.1213C21.6839 20.5587 22 19.7956 22 19V5C22 4.20435 21.6839 3.44129 21.1213 2.87868C20.5587 2.31607 19.7956 2 19 2ZM20 19C20 19.2652 19.8946 19.5196 19.7071 19.7071C19.5196 19.8946 19.2652 20 19 20H5C4.73478 20 4.48043 19.8946 4.29289 19.7071C4.10536 19.5196 4 19.2652 4 19V5C4 4.73478 4.10536 4.48043 4.29289 4.29289C4.48043 4.10536 4.73478 4 5 4H19C19.2652 4 19.5196 4.10536 19.7071 4.29289C19.8946 4.48043 20 4.73478 20 5V19Z" fill="currentColor"></path>
                          </svg>

                                                                  <!-- menu -->

                          <p class="text-white">Etapas</p>
                        </a>
                      </li>
                      <li class="mr-8">
                        <a class="flex flex-wrap items-center py-8 text-base font-medium text-coolGray-500 hover:text-blue-500 border-b-2 border-transparent hover:border-blue-500" href="#duvidas">
                          <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.50003 8.86L11.5 14.06C11.6521 14.1478 11.8245 14.194 12 14.194C12.1756 14.194 12.348 14.1478 12.5 14.06L21.5 8.86C21.6512 8.77275 21.7768 8.64746 21.8646 8.49659C21.9523 8.34572 21.999 8.17452 22 8C22.0007 7.82379 21.9549 7.65053 21.8671 7.49775C21.7792 7.34497 21.6526 7.21811 21.5 7.13L12.5 1.94C12.348 1.85224 12.1756 1.80603 12 1.80603C11.8245 1.80603 11.6521 1.85224 11.5 1.94L2.50003 7.13C2.34743 7.21811 2.22081 7.34497 2.13301 7.49775C2.04521 7.65053 1.99933 7.82379 2.00003 8C2.00108 8.17452 2.04779 8.34572 2.13551 8.49659C2.22322 8.64746 2.34889 8.77275 2.50003 8.86ZM12 4L19 8L12 12L5.00003 8L12 4ZM20.5 11.17L12 16L3.50003 11.13C3.3859 11.0639 3.25981 11.021 3.12903 11.0038C2.99825 10.9866 2.86537 10.9955 2.73803 11.0299C2.61069 11.0643 2.49141 11.1235 2.38706 11.2042C2.28271 11.2849 2.19536 11.3854 2.13003 11.5C1.99966 11.7296 1.96539 12.0015 2.03471 12.2563C2.10403 12.5111 2.2713 12.7281 2.50003 12.86L11.5 18.06C11.6521 18.1478 11.8245 18.194 12 18.194C12.1756 18.194 12.348 18.1478 12.5 18.06L21.5 12.86C21.7288 12.7281 21.896 12.5111 21.9654 12.2563C22.0347 12.0015 22.0004 11.7296 21.87 11.5C21.8047 11.3854 21.7173 11.2849 21.613 11.2042C21.5087 11.1235 21.3894 11.0643 21.262 11.0299C21.1347 10.9955 21.0018 10.9866 20.871 11.0038C20.7402 11.021 20.6142 11.0639 20.5 11.13V11.17ZM20.5 15.17L12 20L3.50003 15.13C3.3859 15.0639 3.25981 15.021 3.12903 15.0038C2.99825 14.9866 2.86537 14.9955 2.73803 15.0299C2.61069 15.0643 2.49141 15.1235 2.38706 15.2042C2.28271 15.2849 2.19536 15.3854 2.13003 15.5C1.99966 15.7296 1.96539 16.0015 2.03471 16.2563C2.10403 16.5111 2.2713 16.7281 2.50003 16.86L11.5 22.06C11.6521 22.1478 11.8245 22.194 12 22.194C12.1756 22.194 12.348 22.1478 12.5 22.06L21.5 16.86C21.7288 16.7281 21.896 16.5111 21.9654 16.2563C22.0347 16.0015 22.0004 15.7296 21.87 15.5C21.8047 15.3854 21.7173 15.2849 21.613 15.2042C21.5087 15.1235 21.3894 15.0643 21.262 15.0299C21.1347 14.9955 21.0018 14.9866 20.871 15.0038C20.7402 15.021 20.6142 15.0639 20.5 15.13V15.17Z" fill="currentColor"></path>
                          </svg>
                          <p  class="text-white" >Duvidas</p>
                        </a>
                      </li>



                      <li class="mr-8">
                        <a class="flex flex-wrap items-center py-8 text-base font-medium text-coolGray-500 hover:text-blue-500 border-b-2 border-transparent hover:border-blue-500 " href="#UnidadesEscolares">
                          <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.21 14.75C10.303 14.8437 10.4136 14.9181 10.5354 14.9689C10.6573 15.0197 10.788 15.0458 10.92 15.0458C11.052 15.0458 11.1827 15.0197 11.3046 14.9689C11.4264 14.9181 11.537 14.8437 11.63 14.75L15.71 10.67C15.8983 10.4817 16.0041 10.2263 16.0041 9.96C16.0041 9.6937 15.8983 9.4383 15.71 9.25C15.5217 9.0617 15.2663 8.95591 15 8.95591C14.7337 8.95591 14.4783 9.0617 14.29 9.25L10.92 12.63L9.71 11.41C9.5217 11.2217 9.2663 11.1159 9 11.1159C8.7337 11.1159 8.4783 11.2217 8.29 11.41C8.1017 11.5983 7.99591 11.8537 7.99591 12.12C7.99591 12.3863 8.1017 12.6417 8.29 12.83L10.21 14.75ZM21 2H3C2.73478 2 2.48043 2.10536 2.29289 2.29289C2.10536 2.48043 2 2.73478 2 3V21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22H21C21.2652 22 21.5196 21.8946 21.7071 21.7071C21.8946 21.5196 22 21.2652 22 21V3C22 2.73478 21.8946 2.48043 21.7071 2.29289C21.5196 2.10536 21.2652 2 21 2ZM20 20H4V4H20V20Z" fill="currentColor"></path>
                          </svg>
                          <p class="text-white" >Unidades</p>
                        </a>
                      </li>
                      <li class="mr-8">
                        <a class="flex flex-wrap items-center py-8 text-base font-medium text-coolGray-500 hover:text-blue-500 border-b-2 border-transparent hover:border-blue-500" href="#contatos">
                          <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 5.49999H12.72L12.4 4.49999C12.1926 3.91322 11.8077 3.4055 11.2989 3.04715C10.7901 2.68881 10.1824 2.49759 9.56 2.49999H5C4.20435 2.49999 3.44129 2.81606 2.87868 3.37867C2.31607 3.94128 2 4.70434 2 5.49999V18.5C2 19.2956 2.31607 20.0587 2.87868 20.6213C3.44129 21.1839 4.20435 21.5 5 21.5H19C19.7956 21.5 20.5587 21.1839 21.1213 20.6213C21.6839 20.0587 22 19.2956 22 18.5V8.49999C22 7.70434 21.6839 6.94128 21.1213 6.37867C20.5587 5.81606 19.7956 5.49999 19 5.49999ZM20 18.5C20 18.7652 19.8946 19.0196 19.7071 19.2071C19.5196 19.3946 19.2652 19.5 19 19.5H5C4.73478 19.5 4.48043 19.3946 4.29289 19.2071C4.10536 19.0196 4 18.7652 4 18.5V5.49999C4 5.23478 4.10536 4.98042 4.29289 4.79289C4.48043 4.60535 4.73478 4.49999 5 4.49999H9.56C9.76964 4.49945 9.97416 4.56481 10.1446 4.68683C10.3151 4.80886 10.4429 4.98137 10.51 5.17999L11.05 6.81999C11.1171 7.01861 11.2449 7.19113 11.4154 7.31315C11.5858 7.43517 11.7904 7.50053 12 7.49999H19C19.2652 7.49999 19.5196 7.60535 19.7071 7.79289C19.8946 7.98042 20 8.23478 20 8.49999V18.5Z" fill="currentColor"></path>
                          </svg>
                          <p class="text-white" >Contatos</p>
                        </a>
                      </li>
                      <li class="mr-8">
                        <a class="flex flex-wrap items-center py-8 text-base font-medium text-coolGray-500 hover:text-blue-500 border-b-2 border-transparent hover:border-blue-500" href="#publicacao">
                          <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 5.49999H12.72L12.4 4.49999C12.1926 3.91322 11.8077 3.4055 11.2989 3.04715C10.7901 2.68881 10.1824 2.49759 9.56 2.49999H5C4.20435 2.49999 3.44129 2.81606 2.87868 3.37867C2.31607 3.94128 2 4.70434 2 5.49999V18.5C2 19.2956 2.31607 20.0587 2.87868 20.6213C3.44129 21.1839 4.20435 21.5 5 21.5H19C19.7956 21.5 20.5587 21.1839 21.1213 20.6213C21.6839 20.0587 22 19.2956 22 18.5V8.49999C22 7.70434 21.6839 6.94128 21.1213 6.37867C20.5587 5.81606 19.7956 5.49999 19 5.49999ZM20 18.5C20 18.7652 19.8946 19.0196 19.7071 19.2071C19.5196 19.3946 19.2652 19.5 19 19.5H5C4.73478 19.5 4.48043 19.3946 4.29289 19.2071C4.10536 19.0196 4 18.7652 4 18.5V5.49999C4 5.23478 4.10536 4.98042 4.29289 4.79289C4.48043 4.60535 4.73478 4.49999 5 4.49999H9.56C9.76964 4.49945 9.97416 4.56481 10.1446 4.68683C10.3151 4.80886 10.4429 4.98137 10.51 5.17999L11.05 6.81999C11.1171 7.01861 11.2449 7.19113 11.4154 7.31315C11.5858 7.43517 11.7904 7.50053 12 7.49999H19C19.2652 7.49999 19.5196 7.60535 19.7071 7.79289C19.8946 7.98042 20 8.23478 20 8.49999V18.5Z" fill="currentColor"></path>
                          </svg>
                          <p class="text-white"id="">Publicação</p>
                        </a>
                      </li>
                      <li class="mr-8">
                        <a class="flex flex-wrap items-center py-8 text-base font-medium text-coolGray-500 hover:text-blue-500 border-b-2 border-transparent hover:border-blue-500" href="#candidato">
                          <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 5.49999H12.72L12.4 4.49999C12.1926 3.91322 11.8077 3.4055 11.2989 3.04715C10.7901 2.68881 10.1824 2.49759 9.56 2.49999H5C4.20435 2.49999 3.44129 2.81606 2.87868 3.37867C2.31607 3.94128 2 4.70434 2 5.49999V18.5C2 19.2956 2.31607 20.0587 2.87868 20.6213C3.44129 21.1839 4.20435 21.5 5 21.5H19C19.7956 21.5 20.5587 21.1839 21.1213 20.6213C21.6839 20.0587 22 19.2956 22 18.5V8.49999C22 7.70434 21.6839 6.94128 21.1213 6.37867C20.5587 5.81606 19.7956 5.49999 19 5.49999ZM20 18.5C20 18.7652 19.8946 19.0196 19.7071 19.2071C19.5196 19.3946 19.2652 19.5 19 19.5H5C4.73478 19.5 4.48043 19.3946 4.29289 19.2071C4.10536 19.0196 4 18.7652 4 18.5V5.49999C4 5.23478 4.10536 4.98042 4.29289 4.79289C4.48043 4.60535 4.73478 4.49999 5 4.49999H9.56C9.76964 4.49945 9.97416 4.56481 10.1446 4.68683C10.3151 4.80886 10.4429 4.98137 10.51 5.17999L11.05 6.81999C11.1171 7.01861 11.2449 7.19113 11.4154 7.31315C11.5858 7.43517 11.7904 7.50053 12 7.49999H19C19.2652 7.49999 19.5196 7.60535 19.7071 7.79289C19.8946 7.98042 20 8.23478 20 8.49999V18.5Z" fill="currentColor"></path>
                          </svg>
                          <p class="text-white">Area do candidato</p>
                        </a>
                      </li>
                    </ul>
                    </ul>

                    </ul>

                  </div>
                  <!--<div class="w-auto p-2">
                    <div class="hidden xl:flex flex-wrap items-center -m-3">
                      <div class="w-auto p-3">
                        <a class="block max-w-max text-coolGray-500 hover:text-coolGray-600" href="#">
                          <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 4H5C4.20435 4 3.44129 4.31607 2.87868 4.87868C2.31607 5.44129 2 6.20435 2 7V17C2 17.7956 2.31607 18.5587 2.87868 19.1213C3.44129 19.6839 4.20435 20 5 20H19C19.7956 20 20.5587 19.6839 21.1213 19.1213C21.6839 18.5587 22 17.7956 22 17V7C22 6.20435 21.6839 5.44129 21.1213 4.87868C20.5587 4.31607 19.7956 4 19 4ZM5 6H19C19.2652 6 19.5196 6.10536 19.7071 6.29289C19.8946 6.48043 20 6.73478 20 7L12 11.88L4 7C4 6.73478 4.10536 6.48043 4.29289 6.29289C4.48043 6.10536 4.73478 6 5 6ZM20 17C20 17.2652 19.8946 17.5196 19.7071 17.7071C19.5196 17.8946 19.2652 18 19 18H5C4.73478 18 4.48043 17.8946 4.29289 17.7071C4.10536 17.5196 4 17.2652 4 17V9.28L11.48 13.85C11.632 13.9378 11.8045 13.984 11.98 13.984C12.1555 13.984 12.328 13.9378 12.48 13.85L20 9.28V17Z" fill="currentColor"></path>
                          </svg>
                        </a>
                      </div>
                      <div class="w-auto p-3">
                        <a class="block max-w-max text-coolGray-500 hover:text-coolGray-600" href="#">
                          <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 13.18V10C17.9986 8.58312 17.4958 7.21247 16.5806 6.13077C15.6655 5.04908 14.3971 4.32615 13 4.09V3C13 2.73478 12.8946 2.48043 12.7071 2.29289C12.5196 2.10536 12.2652 2 12 2C11.7348 2 11.4804 2.10536 11.2929 2.29289C11.1054 2.48043 11 2.73478 11 3V4.09C9.60294 4.32615 8.33452 5.04908 7.41939 6.13077C6.50425 7.21247 6.00144 8.58312 6 10V13.18C5.41645 13.3863 4.911 13.7681 4.55294 14.2729C4.19488 14.7778 4.00174 15.3811 4 16V18C4 18.2652 4.10536 18.5196 4.29289 18.7071C4.48043 18.8946 4.73478 19 5 19H8.14C8.37028 19.8474 8.873 20.5954 9.5706 21.1287C10.2682 21.6621 11.1219 21.951 12 21.951C12.8781 21.951 13.7318 21.6621 14.4294 21.1287C15.127 20.5954 15.6297 19.8474 15.86 19H19C19.2652 19 19.5196 18.8946 19.7071 18.7071C19.8946 18.5196 20 18.2652 20 18V16C19.9983 15.3811 19.8051 14.7778 19.4471 14.2729C19.089 13.7681 18.5835 13.3863 18 13.18ZM8 10C8 8.93913 8.42143 7.92172 9.17157 7.17157C9.92172 6.42143 10.9391 6 12 6C13.0609 6 14.0783 6.42143 14.8284 7.17157C15.5786 7.92172 16 8.93913 16 10V13H8V10ZM12 20C11.651 19.9979 11.3086 19.9045 11.0068 19.7291C10.7051 19.5536 10.4545 19.3023 10.28 19H13.72C13.5455 19.3023 13.2949 19.5536 12.9932 19.7291C12.6914 19.9045 12.349 19.9979 12 20ZM18 17H6V16C6 15.7348 6.10536 15.4804 6.29289 15.2929C6.48043 15.1054 6.73478 15 7 15H17C17.2652 15 17.5196 15.1054 17.7071 15.2929C17.8946 15.4804 18 15.7348 18 16V17Z" fill="currentColor"></path>
                          </svg>
                        </a>
                      </div>-->
                      <div class="w-auto p-3">
                        <div class="flex flex-wrap items-center -m-2">
                          <!-- <div class="w-auto p-2">
                            <div class="flex flex-wrap -m-2">
                              <div class="w-auto p-2">
                                <img src="flex-ui-assets/images/dashboard/navigations/avatar.png" alt="">
                              </div>
                              <div class="w-auto p-2">
                                <h2 class="text-sm font-semibold text-white">John Doe</h2>
                                <p class="text-sm font-medium text-coolGray-500">johndoe@flex.co</p>
                              </div>
                            </div>
                          </div> -->
                          <div class="w-auto p-2">
                            <a class="block max-w-max text-coolGray-500 hover:text-coolGray-600" href="#">
                              <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 9.17C16.8126 8.98375 16.5592 8.87921 16.295 8.87921C16.0308 8.87921 15.7774 8.98375 15.59 9.17L12 12.71L8.46001 9.17C8.27265 8.98375 8.0192 8.87921 7.75501 8.87921C7.49082 8.87921 7.23737 8.98375 7.05001 9.17C6.95628 9.26297 6.88189 9.37357 6.83112 9.49543C6.78035 9.61729 6.75421 9.74799 6.75421 9.88C6.75421 10.012 6.78035 10.1427 6.83112 10.2646C6.88189 10.3864 6.95628 10.497 7.05001 10.59L11.29 14.83C11.383 14.9237 11.4936 14.9981 11.6154 15.0489C11.7373 15.0997 11.868 15.1258 12 15.1258C12.132 15.1258 12.2627 15.0997 12.3846 15.0489C12.5064 14.9981 12.617 14.9237 12.71 14.83L17 10.59C17.0937 10.497 17.1681 10.3864 17.2189 10.2646C17.2697 10.1427 17.2958 10.012 17.2958 9.88C17.2958 9.74799 17.2697 9.61729 17.2189 9.49543C17.1681 9.37357 17.0937 9.26297 17 9.17Z" fill="currentColor"></path>
                              </svg>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button class="navbar-burger self-center ml-auto block xl:hidden">
                      <svg width="35" height="35" viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect class="text-coolGray-800" width="32" height="32" rx="6" fill="currentColor"></rect>
                        <path class="text-white" d="M7 12H25C25.2652 12 25.5196 11.8946 25.7071 11.7071C25.8946 11.5196 26 11.2652 26 11C26 10.7348 25.8946 10.4804 25.7071 10.2929C25.5196 10.1054 25.2652 10 25 10H7C6.73478 10 6.48043 10.1054 6.29289 10.2929C6.10536 10.4804 6 10.7348 6 11C6 11.2652 6.10536 11.5196 6.29289 11.7071C6.48043 11.8946 6.73478 12 7 12ZM25 15H7C6.73478 15 6.48043 15.1054 6.29289 15.2929C6.10536 15.4804 6 15.7348 6 16C6 16.2652 6.10536 16.5196 6.29289 16.7071C6.48043 16.8946 6.73478 17 7 17H25C25.2652 17 25.5196 16.8946 25.7071 16.7071C25.8946 16.5196 26 16.2652 26 16C26 15.7348 25.8946 15.4804 25.7071 15.2929C25.5196 15.1054 25.2652 15 25 15ZM25 20H7C6.73478 20 6.48043 20.1054 6.29289 20.2929C6.10536 20.4804 6 20.7348 6 21C6 21.2652 6.10536 21.5196 6.29289 21.7071C6.48043 21.8946 6.73478 22 7 22H25C25.2652 22 25.5196 21.8946 25.7071 21.7071C25.8946 21.5196 26 21.2652 26 21C26 20.7348 25.8946 20.4804 25.7071 20.2929C25.5196 20.1054 25.2652 20 25 20Z" fill="currentColor"></path>
                      </svg>
                    </button>
                  </div>
                </div>

              </div>
              <div class="navbar-menu z-50 fixed top-0   hidden md:flex xl:hidden flex-col justify-between bg-coolGray-900 max-w-xs w-9/12 h-full overflow-y-auto">
                <div class="navbar-backdrop fixed xl:hidden inset-0 bg-coolGray-900 opacity-60"></div>
                <div class="relative bg-coolGray-900 flex-1">
                  <div class="fixed -left-4 p-8 pl-12 max-w-xs w-9/12 z-50 bg-coolGray-900">
                    <a class="block max-w-max" href="#">
                      <img src="flex-ui-assets/logos/dashboard/flex-ui-green.svg" alt="">
                    </a>
                  </div>
                  <div class="mt-28">
                    <p class="px-8 mb-2 text-xs font-medium text-coolGray-500 uppercase">Main menu</p>
                    <ul class="px-4 mb-8">
                      <li>
                        <a class="p-3 py-4 flex items-center justify-between text-coolGray-500 hover:text-blue-500 hover:bg-blue-500 rounded-md" href="#Etapas">
                          <div class="flex items-center">
                            <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M12 6C11.7348 6 11.4804 6.10536 11.2929 6.29289C11.1054 6.48043 11 6.73478 11 7V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8946 17.5196 13 17.2652 13 17V7C13 6.73478 12.8946 6.48043 12.7071 6.29289C12.5196 6.10536 12.2652 6 12 6ZM7 12C6.73478 12 6.48043 12.1054 6.29289 12.2929C6.10536 12.4804 6 12.7348 6 13V17C6 17.2652 6.10536 17.5196 6.29289 17.7071C6.48043 17.8946 6.73478 18 7 18C7.26522 18 7.51957 17.8946 7.70711 17.7071C7.89464 17.5196 8 17.2652 8 17V13C8 12.7348 7.89464 12.4804 7.70711 12.2929C7.51957 12.1054 7.26522 12 7 12ZM17 10C16.7348 10 16.4804 10.1054 16.2929 10.2929C16.1054 10.4804 16 10.7348 16 11V17C16 17.2652 16.1054 17.5196 16.2929 17.7071C16.4804 17.8946 16.7348 18 17 18C17.2652 18 17.5196 17.8946 17.7071 17.7071C17.8946 17.5196 18 17.2652 18 17V11C18 10.7348 17.8946 10.4804 17.7071 10.2929C17.5196 10.1054 17.2652 10 17 10ZM19 2H5C4.20435 2 3.44129 2.31607 2.87868 2.87868C2.31607 3.44129 2 4.20435 2 5V19C2 19.7956 2.31607 20.5587 2.87868 21.1213C3.44129 21.6839 4.20435 22 5 22H19C19.7956 22 20.5587 21.6839 21.1213 21.1213C21.6839 20.5587 22 19.7956 22 19V5C22 4.20435 21.6839 3.44129 21.1213 2.87868C20.5587 2.31607 19.7956 2 19 2ZM20 19C20 19.2652 19.8946 19.5196 19.7071 19.7071C19.5196 19.8946 19.2652 20 19 20H5C4.73478 20 4.48043 19.8946 4.29289 19.7071C4.10536 19.5196 4 19.2652 4 19V5C4 4.73478 4.10536 4.48043 4.29289 4.29289C4.48043 4.10536 4.73478 4 5 4H19C19.2652 4 19.5196 4.10536 19.7071 4.29289C19.8946 4.48043 20 4.73478 20 5V19Z" fill="currentColor"></path>
                            </svg>
                            <p class="text-blueGray-800 font-medium text-base">Etapas</p>
                          </div>
                          <svg width="12" height="8" viewbox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 1.17C10.8126 0.983753 10.5592 0.879211 10.295 0.879211C10.0308 0.879211 9.77737 0.983753 9.59001 1.17L6.00001 4.71L2.46001 1.17C2.27265 0.983753 2.0192 0.879211 1.75501 0.879211C1.49082 0.879211 1.23737 0.983753 1.05001 1.17C0.956281 1.26297 0.881887 1.37357 0.831118 1.49543C0.780349 1.61729 0.754211 1.74799 0.754211 1.88C0.754211 2.01202 0.780349 2.14272 0.831118 2.26458C0.881887 2.38644 0.956281 2.49704 1.05001 2.59L5.29001 6.83C5.38297 6.92373 5.49357 6.99813 5.61543 7.04889C5.73729 7.09966 5.868 7.1258 6.00001 7.1258C6.13202 7.1258 6.26273 7.09966 6.38459 7.04889C6.50645 6.99813 6.61705 6.92373 6.71001 6.83L11 2.59C11.0937 2.49704 11.1681 2.38644 11.2189 2.26458C11.2697 2.14272 11.2958 2.01202 11.2958 1.88C11.2958 1.74799 11.2697 1.61729 11.2189 1.49543C11.1681 1.37357 11.0937 1.26297 11 1.17Z" fill="#8896AB"></path>
                          </svg>
                        </a>
                      </li>
                      <!-- <li>
                        <a class="p-3 pl-11 flex items-center justify-between" href="#">
                          <div class="flex items-center">
                            <p class="text-white font-medium text-base">Overview</p>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a class="p-3 pl-11 flex items-center justify-between" href="#">
                          <div class="flex items-center">
                            <p class="text-coolGray-500 font-medium text-base">Notifications</p>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a class="p-3 pl-11 flex items-center justify-between" href="#">
                          <div class="flex items-center">
                            <p class="text-coolGray-500 font-medium text-base">Budget</p>
                          </div>
                        </a>
                      </li> -->
                      <li>
                        <a class="p-3 py-4 flex items-center justify-between text-coolGray-500 hover:text-blue-500 hover:bg-blue-500 rounded-md" href="#Dúvidas">
                          <div class="flex items-center">
                            <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M2.50003 8.86L11.5 14.06C11.6521 14.1478 11.8245 14.194 12 14.194C12.1756 14.194 12.348 14.1478 12.5 14.06L21.5 8.86C21.6512 8.77275 21.7768 8.64746 21.8646 8.49659C21.9523 8.34572 21.999 8.17452 22 8C22.0007 7.82379 21.9549 7.65053 21.8671 7.49775C21.7792 7.34497 21.6526 7.21811 21.5 7.13L12.5 1.94C12.348 1.85224 12.1756 1.80603 12 1.80603C11.8245 1.80603 11.6521 1.85224 11.5 1.94L2.50003 7.13C2.34743 7.21811 2.22081 7.34497 2.13301 7.49775C2.04521 7.65053 1.99933 7.82379 2.00003 8C2.00108 8.17452 2.04779 8.34572 2.13551 8.49659C2.22322 8.64746 2.34889 8.77275 2.50003 8.86ZM12 4L19 8L12 12L5.00003 8L12 4ZM20.5 11.17L12 16L3.50003 11.13C3.3859 11.0639 3.25981 11.021 3.12903 11.0038C2.99825 10.9866 2.86537 10.9955 2.73803 11.0299C2.61069 11.0643 2.49141 11.1235 2.38706 11.2042C2.28271 11.2849 2.19536 11.3854 2.13003 11.5C1.99966 11.7296 1.96539 12.0015 2.03471 12.2563C2.10403 12.5111 2.2713 12.7281 2.50003 12.86L11.5 18.06C11.6521 18.1478 11.8245 18.194 12 18.194C12.1756 18.194 12.348 18.1478 12.5 18.06L21.5 12.86C21.7288 12.7281 21.896 12.5111 21.9654 12.2563C22.0347 12.0015 22.0004 11.7296 21.87 11.5C21.8047 11.3854 21.7173 11.2849 21.613 11.2042C21.5087 11.1235 21.3894 11.0643 21.262 11.0299C21.1347 10.9955 21.0018 10.9866 20.871 11.0038C20.7402 11.021 20.6142 11.0639 20.5 11.13V11.17ZM20.5 15.17L12 20L3.50003 15.13C3.3859 15.0639 3.25981 15.021 3.12903 15.0038C2.99825 14.9866 2.86537 14.9955 2.73803 15.0299C2.61069 15.0643 2.49141 15.1235 2.38706 15.2042C2.28271 15.2849 2.19536 15.3854 2.13003 15.5C1.99966 15.7296 1.96539 16.0015 2.03471 16.2563C2.10403 16.5111 2.2713 16.7281 2.50003 16.86L11.5 22.06C11.6521 22.1478 11.8245 22.194 12 22.194C12.1756 22.194 12.348 22.1478 12.5 22.06L21.5 16.86C21.7288 16.7281 21.896 16.5111 21.9654 16.2563C22.0347 16.0015 22.0004 15.7296 21.87 15.5C21.8047 15.3854 21.7173 15.2849 21.613 15.2042C21.5087 15.1235 21.3894 15.0643 21.262 15.0299C21.1347 14.9955 21.0018 14.9866 20.871 15.0038C20.7402 15.021 20.6142 15.0639 20.5 15.13V15.17Z" fill="currentColor"></path>
                            </svg>
                            <p class="text-white font-medium text-base">Dúvidas</p>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a class="p-3 py-4 flex items-center justify-between text-coolGray-500 hover:text-blue-500 hover:bg-blue-500 rounded-md" href="#Unidades">
                          <div class="flex items-center">
                            <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M10.21 14.75C10.303 14.8437 10.4136 14.9181 10.5354 14.9689C10.6573 15.0197 10.788 15.0458 10.92 15.0458C11.052 15.0458 11.1827 15.0197 11.3046 14.9689C11.4264 14.9181 11.537 14.8437 11.63 14.75L15.71 10.67C15.8983 10.4817 16.0041 10.2263 16.0041 9.96C16.0041 9.6937 15.8983 9.4383 15.71 9.25C15.5217 9.0617 15.2663 8.95591 15 8.95591C14.7337 8.95591 14.4783 9.0617 14.29 9.25L10.92 12.63L9.71 11.41C9.5217 11.2217 9.2663 11.1159 9 11.1159C8.7337 11.1159 8.4783 11.2217 8.29 11.41C8.1017 11.5983 7.99591 11.8537 7.99591 12.12C7.99591 12.3863 8.1017 12.6417 8.29 12.83L10.21 14.75ZM21 2H3C2.73478 2 2.48043 2.10536 2.29289 2.29289C2.10536 2.48043 2 2.73478 2 3V21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22H21C21.2652 22 21.5196 21.8946 21.7071 21.7071C21.8946 21.5196 22 21.2652 22 21V3C22 2.73478 21.8946 2.48043 21.7071 2.29289C21.5196 2.10536 21.2652 2 21 2ZM20 20H4V4H20V20Z" fill="currentColor"></path>
                            </svg>
                            <p class="text-white font-medium text-base">Unidades</p>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a class="p-3 py-4 flex items-center justify-between text-coolGray-500 hover:text-blue-500 hover:bg-blue-500 rounded-md" href="#Contatos">
                          <div class="flex items-center">
                            <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M19 5.49999H12.72L12.4 4.49999C12.1926 3.91322 11.8077 3.4055 11.2989 3.04715C10.7901 2.68881 10.1824 2.49759 9.56 2.49999H5C4.20435 2.49999 3.44129 2.81606 2.87868 3.37867C2.31607 3.94128 2 4.70434 2 5.49999V18.5C2 19.2956 2.31607 20.0587 2.87868 20.6213C3.44129 21.1839 4.20435 21.5 5 21.5H19C19.7956 21.5 20.5587 21.1839 21.1213 20.6213C21.6839 20.0587 22 19.2956 22 18.5V8.49999C22 7.70434 21.6839 6.94128 21.1213 6.37867C20.5587 5.81606 19.7956 5.49999 19 5.49999ZM20 18.5C20 18.7652 19.8946 19.0196 19.7071 19.2071C19.5196 19.3946 19.2652 19.5 19 19.5H5C4.73478 19.5 4.48043 19.3946 4.29289 19.2071C4.10536 19.0196 4 18.7652 4 18.5V5.49999C4 5.23478 4.10536 4.98042 4.29289 4.79289C4.48043 4.60535 4.73478 4.49999 5 4.49999H9.56C9.76964 4.49945 9.97416 4.56481 10.1446 4.68683C10.3151 4.80886 10.4429 4.98137 10.51 5.17999L11.05 6.81999C11.1171 7.01861 11.2449 7.19113 11.4154 7.31315C11.5858 7.43517 11.7904 7.50053 12 7.49999H19C19.2652 7.49999 19.5196 7.60535 19.7071 7.79289C19.8946 7.98042 20 8.23478 20 8.49999V18.5Z" fill="currentColor"></path>
                            </svg>
                            <p class="text-white font-medium text-base">Contatos</p>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a class="p-3 py-4 flex items-center justify-between text-coolGray-500 hover:text-blue-500 hover:bg-blue-500 rounded-md" href="#Publicação">
                          <div class="flex items-center">
                            <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M19 5.49999H12.72L12.4 4.49999C12.1926 3.91322 11.8077 3.4055 11.2989 3.04715C10.7901 2.68881 10.1824 2.49759 9.56 2.49999H5C4.20435 2.49999 3.44129 2.81606 2.87868 3.37867C2.31607 3.94128 2 4.70434 2 5.49999V18.5C2 19.2956 2.31607 20.0587 2.87868 20.6213C3.44129 21.1839 4.20435 21.5 5 21.5H19C19.7956 21.5 20.5587 21.1839 21.1213 20.6213C21.6839 20.0587 22 19.2956 22 18.5V8.49999C22 7.70434 21.6839 6.94128 21.1213 6.37867C20.5587 5.81606 19.7956 5.49999 19 5.49999ZM20 18.5C20 18.7652 19.8946 19.0196 19.7071 19.2071C19.5196 19.3946 19.2652 19.5 19 19.5H5C4.73478 19.5 4.48043 19.3946 4.29289 19.2071C4.10536 19.0196 4 18.7652 4 18.5V5.49999C4 5.23478 4.10536 4.98042 4.29289 4.79289C4.48043 4.60535 4.73478 4.49999 5 4.49999H9.56C9.76964 4.49945 9.97416 4.56481 10.1446 4.68683C10.3151 4.80886 10.4429 4.98137 10.51 5.17999L11.05 6.81999C11.1171 7.01861 11.2449 7.19113 11.4154 7.31315C11.5858 7.43517 11.7904 7.50053 12 7.49999H19C19.2652 7.49999 19.5196 7.60535 19.7071 7.79289C19.8946 7.98042 20 8.23478 20 8.49999V18.5Z" fill="currentColor"></path>
                            </svg>
                            <p class="text-white font-medium text-base">Publicação</p>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a class="p-3 py-4 flex items-center justify-between text-coolGray-500 hover:text-blue-500 hover:bg-blue-500 rounded-md" href="#Candidato">
                          <div class="flex items-center">
                            <svg class="mr-2" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M19 5.49999H12.72L12.4 4.49999C12.1926 3.91322 11.8077 3.4055 11.2989 3.04715C10.7901 2.68881 10.1824 2.49759 9.56 2.49999H5C4.20435 2.49999 3.44129 2.81606 2.87868 3.37867C2.31607 3.94128 2 4.70434 2 5.49999V18.5C2 19.2956 2.31607 20.0587 2.87868 20.6213C3.44129 21.1839 4.20435 21.5 5 21.5H19C19.7956 21.5 20.5587 21.1839 21.1213 20.6213C21.6839 20.0587 22 19.2956 22 18.5V8.49999C22 7.70434 21.6839 6.94128 21.1213 6.37867C20.5587 5.81606 19.7956 5.49999 19 5.49999ZM20 18.5C20 18.7652 19.8946 19.0196 19.7071 19.2071C19.5196 19.3946 19.2652 19.5 19 19.5H5C4.73478 19.5 4.48043 19.3946 4.29289 19.2071C4.10536 19.0196 4 18.7652 4 18.5V5.49999C4 5.23478 4.10536 4.98042 4.29289 4.79289C4.48043 4.60535 4.73478 4.49999 5 4.49999H9.56C9.76964 4.49945 9.97416 4.56481 10.1446 4.68683C10.3151 4.80886 10.4429 4.98137 10.51 5.17999L11.05 6.81999C11.1171 7.01861 11.2449 7.19113 11.4154 7.31315C11.5858 7.43517 11.7904 7.50053 12 7.49999H19C19.2652 7.49999 19.5196 7.60535 19.7071 7.79289C19.8946 7.98042 20 8.23478 20 8.49999V18.5Z" fill="currentColor"></path>
                            </svg>
                            <p class="text-white font-medium text-base">Area do Candidato</p>
                          </div>
                        </a>
                      </li>
                    </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>


        <!-- fim menu -->


        <div class="relative h-screen    ">
          <video class="absolute inset-0 w-full h-screen   object-cover " autoplay muted loop>
            <source src="flaro-assets/fundo.mp4" type="video/mp4">

          </video>



          <!-- Restante do seu conteúdo aqui -->
          <div class="absolute inset-0 flex items-center justify-center ">
            <p class="text-white text-12xl font-medium bg-blue-500 bg-opacity-70 rounded-sm px-5 ">Pré Matricula</p>
          </div>

          <div class="absolute inset-40 flex items-center font-bold justify-center z-1" style="top: 60%">
            <a href="https://educacao.mangaratiba.rj.gov.br/matricula">
            <button class="bg-blue-900 bg-opacity-70 text-white px-6 py-4 rounded-md bold">Fazer Inscrição</button>
          </div>
        </div>



        </div>


      <div id="Etapas" class="h-1"></div>

                               <!-- Etapas da Pré-matrícula -->




           <section>


            <div class="py-16 bg-blue-500" >
              <div class="container px-4 mx-auto  text-gray-100">
                <div class="max-w-5xl mx-auto text-center mb-16 md:mb-24">
                  <!-- <span class="inline-block py-px px-2 mb-4 text-xs leading-5 text-green-900 bg-green-100 font-medium uppercase rounded-full shadow-sm">How it works</span> -->
                  <h2 class="mb-4 text-4xl md:text-5xl leading-tight text-white font-bold tracking-tighter">Etapas da Pré-matrícula</h2>
                  <!-- <p class="text-lg md:text-xl text-coolGray-400 font-medium">With our integrated CRM, project management, collaboration and invoicing capabilities, you can manage every aspect of your business in one secure platform.</p> -->
                </div>
                <div class="flex">
                  <div class="w-9/21 pr-20 pb-20">
                      <h2 class="text-lg font-semibold  mb-2">Creche: 6 meses a 03 anos</h2>
                      <ul class="list- pl-6">
                          <li class="mb-2">

                              É a primeira etapa da Educação Infantil e não é obrigatória por lei (LEI 9394/96).
                          </li>
                          <li class="mb-2">

                              Em Mangaratiba essa etapa é oferecida nos Centros de Educação Infantil Municipal – CEIMs.
                          </li>
                          <li class="mb-2">

                              Esta etapa tem Critérios de seleção próprios de Pré-Matrícula, Matrícula e outros procedimentos.
                          </li>
                      </ul>
                  </div>
                  <div class="w-11/20 pl-4">
                      <h2 class="text-lg font-semibold mb-2">Pré-Escola: 04 a 05 anos</h2>
                      <ul class="list-disc pl-6">
                          <li class="mb-2">

                              É a segunda etapa da Educação Infantil e é obrigatória por lei.
                          </li>
                          <li class="mb-2">

                              Em Mangaratiba essa etapa é oferecida nas escolas que atendem essa faixa etária.
                          </li>
                          <li class="mb-2">

                              Obs.: Nessa etapa Não haverá Pré-Matrícula para os CEIMs.
                          </li>
                      </ul>
                  </div>



                      </div>

                <div class="flex flex-wrap -mx-4">
                  <div class="w-full md:w-1/2 lg:w-1/2 px-4 mb-16">
                    <div class="relative h-full px-8 pt-14 pb-8 bg-gray-100 rounded-md shadow-md">
                      <div class="absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 inline-flex items-center justify-center h-16 w-16 bg-coolGray-900 rounded-full">
                        <div class="inline-flex items-center justify-center w-24 h-16 bg-gray-900 rounded-full text-sm font-semibold text-gray-100">etapa 1</div>
                      </div>
                      <h3 class="md:w-64 mb-4 text-lg md:text-xl text-gray-900 font-bold">Pré-Matrícula</h3>

                      <p class=" text-gray-900 font-medium">Ler na íntegra e estar de acordo com as regras do Edital.
                        Preencher total e corretamente a ficha de Pré-Matrícula.
                        Ao concluir a Pré-Matrícula, imprimir o Protocolo.</p>

                    </div>
                  </div>
                  <div class="w-full md:w-1/2 lg:w-1/2 px-4 mb-16">
                    <div class="relative h-full px-8 pt-14 pb-8 bg-gray-100 rounded-md shadow-md">
                      <div class="absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 inline-flex items-center justify-center h-16 w-16 bg-coolGray-900 rounded-full">
                        <div class="inline-flex items-center justify-center w-24 h-16 bg-gray-900 rounded-full text-sm font-semibold text-gray-100">etapa 2</div>
                      </div>
                      <h3 class="md:w-64 mb-4 text-lg md:text-xl text-gray-900 font-bold">Período de entrega de documentos referentes à:</h3>

                      <p class=" text-gray-900 font-medium">Vulnerabilidade social e/ou econômica: A documentação comprobatória do parecer técnico da Assistente Social do CRAS, deve ser entregue na Secretaria Municipal de Educação, no período de 5 dias após o recebimento do mesmo.
            Deficiência: A documentação comprobatória deve ser entregue na Secretaria Municipal de Educação no período de 48 horas,
            conforme o Edital n° 02/SMEEL/2023 - item 2.12</p>

                    </div>
                  </div>
                  <div class="w-full md:w-1/2 lg:w-1/2 px-4 mb-16">
                    <div class="relative h-full px-8 pt-14 pb-8 bg-gray-100 rounded-md shadow-md">
                      <div class="absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 inline-flex items-center justify-center h-16 w-16 bg-coolGray-900 rounded-full">
                        <div class="inline-flex items-center justify-center w-24 h-16 bg-gray-900 rounded-full text-sm font-semibold text-gray-100">etapa 3</div>
                      </div>
                      <h3 class="md:w-64 mb-4 text-lg md:text-xl text-gray-900 font-bold">Classificação</h3>

                      <p class=" text-gray-900 font-medium">As classificações ocorrerão de forma eletrônica pelo Sistema Eletrônico de Cadastro de Pré-matrícula da Educação Infantil no momento da abertura da vaga, respeitando a capacidade máxima de atendimento das turmas de cada unidade e os critérios estabelecidos por ordem de prioridade.
                        Para a classificação serão considerados os seguintes critérios e prioridades:
                        Alunos classificados e aguardando vaga conforme Portaria SMEEL nº 42/2024, publicada em Diário Oficial do Município e Mangaratiba em 13 de novembro de 2024, Ano XX, nº 2169; 10% (dez por cento) de Vulnerabilidade Social e/ou Econômica; Ordem de inscrição no Sistema.</p>

                    </div>
                  </div>
                  <div class="w-full md:w-1/2 lg:w-1/2 px-4 mb-16">
                    <div class="relative h-full px-8 pt-14 pb-8 bg-gray-100 rounded-md shadow-md">
                      <div class="absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 inline-flex items-center justify-center h-16 w-16 bg-coolGray-900 rounded-full">
                        <div class="inline-flex items-center justify-center w-24 h-16 bg-gray-900 rounded-full text-sm font-semibold text-gray-100">etapa 4</div>
                      </div>
                      <h3 class="md:w-64 mb-4 text-lg md:text-xl text-gray-900 font-bold">Matrícula</h3>

                      <p class=" text-gray-900 font-medium">8.1 A efetivação da matrícula somente será feita no Centro de Educação Infantil Municipal - CEIM em que o Sistema Eletrônico de Inscrição da Educação Infantil classificou e após a entrega da documentação, da verificação e comprovação das informações no ato da matrícula.
                        8.2 O não comparecimento dos pais e/ou responsáveis legais em firmar a matrícula acarretará na perda da vaga e finalização do cadastro.
                        8.3 A criança que tiver 04 anos completos no ato da convocação para matrícula e não efetivarem a mesma terão vaga garantida em outra unidade de Educação Infantil com atendimento parcial.
                        8.4 Ao final do período de matrícula nos CEIMs a Direção deverá encaminhar para SMEEL a relação dos candidatos que não compareceram para efetivação da matrícula, para o cumprimento do item 8.2.</p>

                    </div>
                  </div>
                  <div  class="w-full md:w-1/2 lg:w-full px-4 mt-4 mb-16 md:mb-0">
                    <div class="relative h-full px-8 pt-14 pb-8 bg-gray-100 rounded-md shadow-md">
                      <div class="absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 inline-flex items-center justify-center h-16 w-16 bg-coolGray-900 rounded-full">
                        <div  class="inline-flex items-center justify-center w-12 h-12 bg-gray-900 rounded-full text-xl font-semibold  text-gray-100">5</div>
                      </div>
                      <h3 class="md:w-64 mb-4 text-lg md:text-xl text-gray-900 font-bold">Parabéns!</h3>
                      <p  id="duvidas" class="text-gray-900 font-medium">A Secretaria de Educação agradece a preferência e a confiança em matricular o seu/sua filho (a) no nosso Sistema de Ensino, que prima pela qualidade no atendimento aos nossos pequenos, desde os cuidados com a saúde e higiene até o objetivo principal da Educação Infantil em nosso município, que é oferecer uma proposta pedagógica pautada no brincar e educar, desenvolvendo competências e habilidades para a vida.</p>
                    </div>
                  </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>

   </section>






</div>

</div>

                                                <!-- fim duvidas -->


<section class="pt-20 pb-36 bg-blue-500  bg-opacity-80   overflow-hidden" id="UnidadesEscolares">
  <div class="container px-4 mx-auto">
    <h2 class="mb-6 text-7xl md:text-8xl xl:text-10xl text-center text-white font-bold font-heading tracking-px-n leading-none">Unidades Escolares</h2>

      <p class="mb-20 text-lg text-center w-full text-gray-800 font-medium leading-normal ">Centros de Educação Infantil Municipal – CEIMs.</p>

    <div class="flex flex-wrap -m-8">
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-aarao-de-moura-brito-filho.jpg" alt="">

                <a class="inline-block text-white hover:text-gray-200 hover:underline "  href="#">
                  <h3 class="text-1x1 font-bold  font-heading leading-normal "> CEIM Arao Brito Filho</h3>
                </a>
                <p class="mt-4 text-sm text-gray-400 font-medium"> End :Rua João Bermudes de Castro s/nº - Serrado - Itacuruçá.</p>
             </div>
            </div>
          </div>
        </div>
      </div>



      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40  transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-prof-denise-lopes-de-souza-mendes.jpg" alt="">
                <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                  <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Profª Denise Lopes de Souza Mendes</h3>
                  <p class="text-sm text-gray-400 font-medium">Rua Major Dinart Silveira s/nº - Conceição de Jacareí.</p>
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40  transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-davi-de-oliveira-brojo.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                <h3 class="text-1x1 font-bold font-heading leading-normal"> Davi de Oliveira Brojo</h3>
                <p class="mt-4 text-sm text-gray-400 font-medium"> Estrada São João Marcos,lt 05 s/nº - El Ranchito - Mangaratiba.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-merendeira-devany-macedo-da-silva.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Merendeira Devany Macedo da Silva </h3>
                <p class="mt-4 text-sm text-gray-400 font-medium"> Rua Ivan nº 74 - Muriqui.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-nilton-xavier-p.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Nilton Xavier</h3>
                <p class="mt-4 text-sm text-gray-400 font-medium"> Rua Projetada B – Serrado - Itacuruçá.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full  h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-norma-pinheiro-cardoso.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                        <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Norma Pinheiro Cardoso</h3>
                        <p class=" text-sm text-gray-400 font-medium"> Rua José Alves de Souza – Parque Bela Vista - Mangaratiba.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 transform hover:scale-105 transition ease-in-out  duration-1000 " src="flaro-assets/images/blog/ceim-prof-cybele-rea-jannuzzi-ruzzi.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                        <h3 class="text-sm font-bold font-heading leading-normal ">CEIM Profª Cybele Réa Jannuzzi Ruzzi</h3>
                        <p class="   text-sm text-gray-400 font-medium"> Rua Pará nº 308, Qd 13, Lt11 - Praia do Saco - Mangaratiba.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-prof-laura-jacobina-lacombe.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                        <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Profª Laura Jacobina Lacombe</h3>
                        <p class=" text-sm text-gray-400 font-medium"> Estrada São João Marcos s/nº - Nova Mangaratiba - Mangaratiba.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-prof-marcia-laurentino-ferreira-moreira.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Profª Márcia Laurentino Ferreira Moreira</h3>
                <p class="text-sm text-gray-400 font-medium"> Rua José Alves de Souza e Silva s/nº - Parque Bela Vista - Mangaratiba.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-santa-justina.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Santa Justina</h3>
                <p class="mt-4 text-sm text-gray-400 font-medium">Rua Sandra Mara Cabral s/nº - Praia do Saco - Mangaratiba.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-sara-camara.jpeg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Sara Câmara da Rocha</h3>
                <p class="mt-4 text-sm text-gray-400 font-medium"> ua Amazonas nº106 - Praia do Saco - Mangaratiba.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb- w-full overflow-hidden rounded-2xl">
                <img class="w-full h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-frei-affonso-jorge-braga-p.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Frei Affonso Jorge Braga</h3>
                <p class="mt-4 text-sm text-gray-400 font-medium"> Estrada RJ 14 s/nº - Muriqui.</p>
              </a>
              </div>


            </div>
          </div>
        </div>
      </div>
      <!-- <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-0 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">



            </div>
          </div>
        </div>
      </div> -->
      <div class="w-full md:w-1/3 p-1">
        <div class="p-4 h-60 bg-gray-900 bg-opacity-70 rounded-xl">
          <div class="flex flex-col justify-between h-full">
            <div class="mb-8">
              <div class="mb-9 w-full overflow-hidden rounded-2xl">
                <img class="w-full  h-40 transform hover:scale-105 transition ease-in-out duration-1000" src="flaro-assets/images/blog/ceim-daise-maria-pires-dos-santos-p.jpg" alt="">
                       <a class="inline-block text-white hover:text-gray-200 hover:underline" href="#">
                <h3 class="text-1x1 font-bold font-heading leading-normal">CEIM Daise Maria Pires dos Santos</h3>
                <p  id="contatos"  class="text-sm text-gray-400 font-medium"> Rua Projetada 2 s/nº - Vila Benedita - Itacuruçá.</p>
              </a>
              </div>


    </div>
  </div>
</section>









            </div>
          </div>





          </div>
        </div>
      </section>



   <section>

        <div class="bg-gray-900 bg-opacity-95 " >





          <div class="border-b border-coolGray-800 "></div>

          <div class="container px-4 mx-auto">
            <p class="py-2 md:pb-8 text-lg md:text-md text-white font-normal text-center"> Endereço:<br> Praça Robert Simões, nº 92 - Mangaratiba - RJ <br>
              Telefone: (21) 2789-6000 <br>
              Ramal da Sec. de Educação: 280</p>
          </div>
          <div class="border-b border-coolGray-800"></div>
          <div class="container px-4 mx-auto">

            <p class="py-2 pb-4 text-lg md:text-sm text-white font-medium text-center">© 2025  Todos os direitos reservado: Secretaria de Ciência, Tecnologia e Inovação.</p>

          </div>
        </div>




   </section>


    </div>




</body>
</html>
