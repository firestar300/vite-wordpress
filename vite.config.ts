import { defineConfig } from 'vite'

// @ts-check
export default defineConfig(({ command, mode }) => {
  if (command === 'serve') {
    return {
      // dev specific config
      root: 'src',
      server: {
        strictPort: true,
        // https: true,
      },
    }
  } else {
    // command === 'build'
    return {
      base: '/',
      build: {
        manifest: true,
        outDir: 'dist/',
        emptyOutDir: true,
        rollupOptions: {
          input: './src/js/index.js',
        },
      },
    }
  }
})
