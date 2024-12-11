import { createAlova } from 'alova'
import { axiosRequestAdapter } from '@alova/adapter-axios'

import VueHook from 'alova/vue'

export interface ApiResponse<T> {
  /**
   * 数据
   */
  data: T
  /**
   * 消息
   */
  msg?: string
  /**
   * 错误信息
   */
  errors?: Record<string, string>
  /**
   * 状态码
   */
  status: number
}

export const alovaInstance = createAlova({
  baseURL: window.AmisAdmin.apiBase,
  // 超时时间
  timeout: 1000 * 30,
  // 请求适配器
  requestAdapter: axiosRequestAdapter(),
  // 缓存时间
  cacheFor: {},
  statesHook: VueHook,
  beforeRequest: () => {},
  responded: {
    onSuccess: async (response) => {
      const data = await response.data
      if (data.status !== 0) {
        if (data.status == 401) {
          useUserStore().logoutCallBack()
          return
        }
        throw new Error(data.msg)
      }
      return data.data
    },
    onError: (error) => {
      if (error.response.status === 401) {
        useUserStore().logoutCallBack()
        return
      }
      throw new Error(error.response.data.msg ?? error.response.data.message)
    }
  }
})
