import type { MenuItem } from '@/stores/modules/user/types'

export interface LoginData {
  username: string
  password: string
  remember: boolean
}

export interface LoginRes {
  token_type: string
  expires_in: number
  access_token: string
  refresh_token: string
}

export function apiUserLogin(data: LoginData) {
  const method = alovaInstance.Post<LoginRes>('/auth/login', data)
  return method
}

export function apiUserLogout() {
  const method = alovaInstance.Get('/auth/logout')
  return method
}

export function apiGetMenuList() {
  const method = alovaInstance.Get<{
    active_menus: { [key: string]: string[] }
    menus: MenuItem[]
  }>('/userMenus')
  return method
}

export async function apiGetPageRenderer(path: string, params?: any) {
  const method = alovaInstance.Get<any>(path, params)
  return method
}
