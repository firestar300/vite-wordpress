/* eslint-disable indent */
if (import.meta.env.MODE !== 'development') {
  // eslint-disable-next-line prettier/prettier
  import('vite/modulepreload-polyfill')
}

import '../scss/style.scss'

document.querySelector('#app').innerHTML = `
  <h1>Hello Vite!</h1>
  <a href="https://vitejs.dev/guide/features.html" target="_blank">Documentation</a>
`
