import { defineConfig } from 'vite'
import liveReload from 'vite-plugin-live-reload'
import eslintPlugin from 'vite-plugin-eslint';
import path from 'path'

const themeDirName = path.basename(__dirname);

// @ts-check
export default defineConfig(({ command, mode }) => {
  const settings = {
    plugins: [
      liveReload(`${__dirname}/**/*\.php`),
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
            replacement: `../../../wp-content/themes/${themeDirName}/`,
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
          input: './src/js/main.js',
        },
      },
    }
  }
})
