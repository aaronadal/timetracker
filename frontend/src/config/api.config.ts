export const API_CONFIG = {
  BASE_URL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000',
  HEADERS: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
} as const
