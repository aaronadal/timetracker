export type ApiMethod = 'get' | 'post' | 'put' | 'delete'

// eslint-disable-next-line @typescript-eslint/no-explicit-any
export type ArgumentsType = Record<string, any>

export type ApiCreatedResponse = { id: string }

export interface ApiClient {
  request<ReturnType>(
    endpoint: string,
    method: ApiMethod,
    args?: ArgumentsType,
  ): Promise<ReturnType>
}
