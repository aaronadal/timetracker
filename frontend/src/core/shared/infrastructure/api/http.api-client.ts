import axios, {type AxiosResponse} from 'axios'
import type {ApiClient, ApiMethod, ArgumentsType} from "@/core/shared/domain/api/api-client.ts";
import {API_CONFIG} from "@/config/api.config.ts";

interface ApiResponse<T> {
  status: number,
  success: boolean,
  timestamp: number,
  payload: T,
}

export class HttpApiClient implements ApiClient {
  async request<ReturnType>(
    endpoint: string,
    method: ApiMethod,
    args?: ArgumentsType,
  ): Promise<ReturnType> {
    const response = await axios.request<ApiResponse<ReturnType>>({
      method: method,
      url: `${API_CONFIG.BASE_URL}${endpoint}`,
      headers: API_CONFIG.HEADERS,
      params: this.allowsParams(method) ? args : undefined,
      data: this.allowsData(method) ? args : undefined,
    });

    return this.parseResponse(response);
  }

  private parseResponse<ReturnType>(
    response: AxiosResponse<ApiResponse<ReturnType>>,
  ): ReturnType {
    return response.data.payload;
  }

  private allowsData(method: ApiMethod): boolean {
    return ["post", "put"].includes(method);
  }

  private allowsParams(method: ApiMethod): boolean {
    return ["get"].includes(method);
  }
}
