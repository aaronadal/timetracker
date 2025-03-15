export type ApiMethod = 'get'|'post'|'put'|'delete';
export type ArgumentsType = Record<string, any>;

export interface ApiClient {
  request<ReturnType>(
    endpoint: string,
    method: ApiMethod,
    args?: ArgumentsType,
  ): Promise<ReturnType>;
}
