<template>
  <div class="preloader">
    <div class="preloader-content">
      <div class="logo-circle">
        <svg class="spinner" viewBox="0 0 50 50">
          <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5" />
        </svg>
      </div>
      <h2>Secretaria Municipal de Educação</h2>
      <p>👋 Olá, seja bem-vindo! Em instantes você será direcionado para a página de pré-matrícula. </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Preloader',
};
</script>

<style scoped>
.preloader {
  position: fixed;
  inset: 0;
  background: linear-gradient(135deg, #3b82f6, #06b6d4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.preloader-content {
  text-align: center;
  color: #ffffff;
  animation: fadeIn 1.2s ease-in-out;
}

.logo-circle {
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  width: 80px;
  height: 80px;
  margin: 0 auto 20px;
  box-shadow: 0 0 12px rgba(255, 255, 255, 0.2);
}

.spinner {
  animation: spin 3.0s cubic-bezier(0.4, 0, 0.2, 1) infinite;
  width: 40px;
  height: 40px;
}

.path {
  stroke: #fff;
  stroke-linecap: round;
  stroke-dasharray: 90, 150;
  stroke-dashoffset: 0;
  animation: dash 1.5s ease-in-out infinite;
}

h2 {
  font-size: 1.8rem;
  font-weight: 600;
  margin-bottom: 8px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

p {
  font-size: 1rem;
  font-weight: 300;
  opacity: 0.9;
}

@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}

@keyframes dash {
  0% {
    stroke-dasharray: 1, 200;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -40px;
  }
  100% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -120px;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.98);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
