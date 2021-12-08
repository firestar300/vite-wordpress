/* eslint-disable indent */
if (import.meta.env.MODE !== 'development') {
  // eslint-disable-next-line prettier/prettier
  import('vite/modulepreload-polyfill')
}

import '../scss/style.scss'
import lazySizes from 'lazysizes'
import 'lazysizes/plugins/native-loading/ls.native-loading'
import 'lazysizes/plugins/object-fit/ls.object-fit'
import 'what-input'

/**
 * LazySizes configuration
 * https://github.com/aFarkas/lazysizes/#js-api---options
 */
lazySizes.cfg.nativeLoading = {
  setLoadingAttribute: false,
}
