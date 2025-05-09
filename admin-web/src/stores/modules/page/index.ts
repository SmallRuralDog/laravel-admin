import Nprogress from 'nprogress'
import type { pageList } from './types'
import type { MenuItem } from '../user/types'
Nprogress.configure({ showSpinner: false })

const usePagesStore = defineStore('pages', () => {
  const pages: pageList = {}

  const thisPage = ref({
    loading: true,
    error: false,
    status: 0,
    errorMessage: '',
    pageJson: null as any,
    showMenu: true,
    showHeader: true
  })

  const getPageJson = async (path: string, params?: any) => {
    Nprogress.start()
    thisPage.value.loading = true
    const [err, res] = await to(apiGetPageRenderer(path, params))
    thisPage.value.loading = false
    Nprogress.done()
    if (err) {
      thisPage.value.error = true
      thisPage.value.status = 404
      thisPage.value.errorMessage = err.message
      return
    }

    if (res.action) {
      if (res.action == 'jump' && res.url) {
        window.location.href = res.url
      }
      if (res.action == 'renderPage') {
        thisPage.value.showHeader = res.showHeader ?? true
        thisPage.value.showMenu = res.showMenu ?? true
      }
    } else {
      thisPage.value.showHeader = true
      thisPage.value.showMenu = true
    }

    pages[path] = res
    thisPage.value.status = res.status ?? 0
    thisPage.value.pageJson = pages[path]
    thisPage.value.error = false
  }

  const { appAsyncMenus } = storeToRefs(useAppStore())

  const findMenuBreadcrumb = (target: string) => {
    const result: string[] = []
    let isFind = false
    const backtrack = (item: MenuItem, titles: string[]) => {
      if (item.id === target) {
        isFind = true
        result.push(...titles, item.name)
        return
      }
      if (item.children?.length) {
        item.children.forEach((el) => {
          backtrack(el, [...titles, item.name])
        })
      }
    }
    appAsyncMenus.value.forEach((el: MenuItem) => {
      if (isFind) return
      backtrack(el, [])
    })

    return result
  }

  const thisMenu = ref<MenuItem>()
  const pageBreadcrumb = ref<string[]>([])
  listenerRouteChange((route: MenuItem) => {
    thisMenu.value = route
    pageBreadcrumb.value = findMenuBreadcrumb(route.id)
  }, true)

  return {
    thisPage,
    pageBreadcrumb,
    getPageJson
  }
})

export default usePagesStore
