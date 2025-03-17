import type { User } from '@/core/auth/domain/entity/user.ts'

export interface UserRepositoryInterface {
  all(): Promise<User[]>
  create(name: string): Promise<User>
}
