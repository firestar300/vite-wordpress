import { defineConfig } from 'vite'
import eslintPlugin from 'vite-plugin-eslint';

// @ts-check
export default defineConfig(({ command, mode }) => {
  const settings = {
    plugins: [
      eslintPlugin(),
    ],
  }

  if (command === 'serve') {
    return {
      ...settings,
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
      ...settings,
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
