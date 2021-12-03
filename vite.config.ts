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
      resolve: {
        alias: [
          {
            find: '@theme',
            replacement: '../../../wp-content/themes/vite-wordpress/',
          },
        ]
      },
      server: {
        strictPort: true,
        // https: true,
      },
    }
  } else {
    // command === 'build'
    return {
      ...settings,
      base: './',
      resolve: {
        alias: [
          {
            find: '@theme',
            replacement: './',
          },
        ]
      },
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
