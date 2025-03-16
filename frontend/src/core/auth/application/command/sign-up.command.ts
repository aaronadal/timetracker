import type {UserRepositoryInterface} from "@/core/auth/domain/repository/user.repository.ts";
import type {User} from "@/core/auth/domain/entity/user.ts";

export class SignUpCommand {
  constructor(
    private readonly repo: UserRepositoryInterface,
  ) {}

  async run(name: string): Promise<User> {
    return this.repo.create(name);
  }
}
