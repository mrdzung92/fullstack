import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
const BASE_URL = 'http://duobao.local'
export default defineConfig({
  plugins: [
    vue(),
  ],
  build: {
    outDir: 'Z:/www/dbshop/client'
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  define: {
    'process.env': {
      VITE_API_BASE_URL:BASE_URL,
    },
  },
  server: {
    proxy: {
      '/captcha':BASE_URL,
      '/storage':BASE_URL,
    },
  },
})