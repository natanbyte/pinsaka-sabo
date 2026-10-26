import { defineConfig } from 'vite'

export default defineConfig({
  root: './resources',
  build: {
    outDir: '../public/assets',
    rollupOptions: {
      input: './css/input.css'
    }
  }
})
