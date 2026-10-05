import { defineConfig } from 'vite'
import symfonyPlugin from 'vite-plugin-symfony'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    react(),
    tailwindcss(),
    symfonyPlugin({ viteDevServerHostname: 'localhost' }),
  ],
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    watch: { usePolling: true },   // para que Vite detecte cambios desde Windows
  },
  build: {
    rollupOptions: {
      input: { app: './assets/app.jsx' },
    },
  },
})
