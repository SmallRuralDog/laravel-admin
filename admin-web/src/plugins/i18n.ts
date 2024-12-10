import type { App } from 'vue'
import { createI18n } from 'vue-i18n'
import zhCN from '@/locales/zh-CN.json'
import en from '@/locales/en.json'
import zhTW from '@/locales/zh-TW.json'
import vi from '@/locales/vi.json'
import id from '@/locales/id.json'

const i18n = createI18n({
  locale: window.AmisAdmin.currentLanguage,
  fallbackLocale: 'zh-CN',
  messages: {
    zh_CN: zhCN,
    en: en,
    zh_TW: zhTW,
    vi: vi,
    id: id
  }
})

type Language = typeof i18n.global.locale

export { i18n, type Language }

export const useAppI18n = (app: App) => {
  app.use(i18n)
}
