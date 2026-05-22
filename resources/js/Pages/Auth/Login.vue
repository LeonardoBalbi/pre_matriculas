<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="LOGIN - SME" />

    <!-- Conteúdo principal -->
    <div class="limiter">
        <!-- Vídeo de background -->
        <video class="background-video" autoplay muted loop>
            <source src="/video/login_educacao.mp4" type="video/mp4">
        </video>

        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img :src="`${$page.props.base_url || ''}/bt/images/img-01.png`" alt="IMG">
                </div>
                <form @submit.prevent="submit" class="login100-form validate-form">
                    <span class="login100-form-title">
                        Área de Login - SME
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="Precisa ter um email valido, exemplo: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email" v-model="form.email" required autofocus autocomplete="username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    <InputError class="mt-2" :message="form.errors.email" />
                    <div class="wrap-input100 validate-input" data-validate="Precisa digitar uma senha">
                        <input class="input100" type="password" name="password" placeholder="Senha" v-model="form.password" required autocomplete="current-password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <InputError class="mt-2" :message="form.errors.password" />
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" :disabled="form.processing">
                            Entrar
                        </button>
                    </div>
                    <div class="w-full text-center py-4 text-gray-600 text-sm mt-8"> © 2025 Todos os direitos reservados: <strong>Secretaria de Ciência, Tecnologia </strong>. </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style scoped>
/* Background com vídeo */
.limiter {
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    position: relative;
    overflow: hidden;
}

.background-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
}

.container-login100 {
    width: 100%;
    max-width: 800px;
    height: 400px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    backdrop-filter: blur(5px);
    position: relative;
    z-index: 1;
}

.wrap-login100 {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 40px;
}
/* Reduz o espaçamento entre os campos */
.wrap-input100 {
    margin-bottom: 15px;
}
/* Inputs mais arredondados */
.input100 {
    border-radius: 25px !important;
    padding: 10px 20px;
    border: 1px solid #ccc;
    font-size: 16px;
}
/* Botão mais próximo dos campos */
.container-login100-form-btn {
    margin-top: 10px;
}
/* Centralizar melhor a área do login */
.wrap-login100 {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}
/* Centralizar o formulário */
.login100-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 400px;
}
/* Centralizar o botão */
.login100-form-btn {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
    display: block;
}
/* Centralizar o título */
.login100-form-title {
    text-align: center;
    color: hsl(207, 56%, 50%);
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 30px;
}
/* Animação da imagem ao passar o mouse */
.login100-pic {
    transition: transform 0.3s ease, filter 0.3s ease;
}
.login100-pic:hover {
    transform: scale(1.05);
    filter: brightness(1.1);
}
/* Botão verde */
.login100-form-btn {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    border-radius: 25px !important;
    padding: 10px 80px;
    color: white !important;
    transition: all 0.3s ease;
}
.login100-form-btn:hover {
    border-radius: 25px !important;
    background-color: #218838 !important;
    padding: 10px 84px;
    border-color: #1e7e34 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
/* Texto de direitos reservados na parte inferior */
.wrap-login100 {
    position: relative;
    min-height: 100%;
}
.wrap-login100 .w-full {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px;
    background: rgba(255,255,255,0.9);
    border-radius: 0 0 10px 10px;
}
</style>
