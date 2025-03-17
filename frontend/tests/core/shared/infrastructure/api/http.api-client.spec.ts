import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest'
import axios from 'axios'
import { HttpApiClient } from '../../../../../src/core/shared/infrastructure/api/http.api-client'
import { TimestampProvider } from '../../../../../src/core/shared/domain/timestamp-provider'
import { API_CONFIG } from '../../../../../src/config/api.config'

vi.mock('axios')

describe('HttpApiClient', () => {
  let apiClient: HttpApiClient

  beforeEach(() => {
    apiClient = new HttpApiClient()
  })

  afterEach(() => {
    vi.resetAllMocks()
  })

  it('should make a GET request with query params', async () => {
    const response = mockResponse();
    
    vi.mocked(axios.request).mockResolvedValueOnce(response)

    const result = await apiClient.request('/users/123', 'get', { foo: 'bar' })

    expect(result).toEqual(response.data.payload)
    expect(axios.request).toHaveBeenCalledWith({
      method: 'get',
      url: `${API_CONFIG.BASE_URL}/users/123`,
      headers: API_CONFIG.HEADERS,
      params: { foo: 'bar' },
      data: undefined
    })
  })

  it('should make a POST request with body', async() => {
    const response = mockResponse();

    vi.mocked(axios.request).mockResolvedValueOnce(response)

    const result = await apiClient.request('/users/123', 'post', { foo: 'bar' })

    expect(result).toEqual(response.data.payload)
    expect(axios.request).toHaveBeenCalledWith({
      method: 'post',
      url: `${API_CONFIG.BASE_URL}/users/123`,
      headers: API_CONFIG.HEADERS,
      params: undefined,
      data: { foo: 'bar' },
    });
  })

  it('should make a PUT request with body', async () => {
    const response = mockResponse();

    vi.mocked(axios.request).mockResolvedValueOnce(response)

    const result = await apiClient.request('/users/123', 'put', { foo: 'bar' })

    expect(result).toEqual(response.data.payload)
    expect(axios.request).toHaveBeenCalledWith({
      method: 'put',
      url: `${API_CONFIG.BASE_URL}/users/123`,
      headers: API_CONFIG.HEADERS,
      params: undefined,
      data: { foo: 'bar' }
    })
  })

  it('should make a DELETE request without any data', async () => {
    const response = mockResponse();
    
    vi.mocked(axios.request).mockResolvedValueOnce(response)

    const result = await apiClient.request('/users/123', 'delete', { foo: 'bar' })

    expect(result).toEqual(response.data.payload)
    expect(axios.request).toHaveBeenCalledWith({
      method: 'delete',
      url: `${API_CONFIG.BASE_URL}/users/123`,
      headers: API_CONFIG.HEADERS,
      params: undefined,
      data: undefined
    })
  })
})

function mockResponse() {
  return {
    data: {
      status: 200,
      success: true,
      timestamp: TimestampProvider.now(),
      payload: { id: '123', name: 'Foo' }
    }
  }
}
