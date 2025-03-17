import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import App from '../../src/ui/App.vue'
import { container } from '../../src/core/container'
import { User } from '../../src/core/auth/domain/entity/user'
import { WorkEntry } from '../../src/core/tracking/domain/entity/work-entry.root'
import { TimestampProvider } from '../../src/core/shared/domain/timestamp-provider'

vi.mock('../../src/ui/views/NoUsersView.vue', () => ({
    default: {
      name: 'NoUsersView',
      template: `<div class="no-users-view"></div>`,
    }
  }))

vi.mock('../../src/ui/views/UserEntriesView.vue', () => ({
    default: {
      name: 'UserEntriesView',
      template: `<div class="user-entries-view"></div>`,
      props: ['users', 'currentUser', 'entries']
    }
  }))

describe('App', () => {
  const now = TimestampProvider.now();

  const mockUsers: User[] = [
    new User('user-1', 'User 1', now, now),
    new User('user-2', 'User 2', now, now),
  ]

  const mockEntries: WorkEntry[] = [
    new WorkEntry('entry-1', 'user-1', now, null, now, now)
  ]

  const mockAllUsersQuery = { run: vi.fn() }
  const mockUserEntriesQuery = { run: vi.fn() }

  beforeEach(() => {
    vi.spyOn(container, 'get').mockImplementation((key: string) => {
      switch (key) {
        case 'Auth.User.Query.All':
          return mockAllUsersQuery
        case 'Tracking.WorkEntry.Query.AllByUser':
          return mockUserEntriesQuery
        default:
          throw new Error(`Unknown key: ${key}`)
      }
    })
  })

  it('shows NoUsersView when no users are available', async () => {
    mockAllUsersQuery.run.mockResolvedValueOnce([])

    const wrapper = mount(App)
    await wrapper.vm.$nextTick()
    await wrapper.vm.$nextTick()

    expect(wrapper.findComponent({ name: 'NoUsersView' }).exists()).toBe(true)
    expect(wrapper.findComponent({ name: 'UserEntriesView' }).exists()).toBe(false)
  })

  it('shows UserEntriesView when users are available', async () => {
    mockAllUsersQuery.run.mockResolvedValueOnce(mockUsers)
    mockUserEntriesQuery.run.mockResolvedValueOnce(mockEntries)

    const wrapper = mount(App)
    await wrapper.vm.$nextTick()
    await wrapper.vm.$nextTick()

    expect(mockAllUsersQuery.run).toHaveBeenCalled()
    expect(mockUserEntriesQuery.run).toHaveBeenCalledWith('user-1')
    expect(wrapper.findComponent({ name: 'NoUsersView' }).exists()).toBe(false)
    expect(wrapper.findComponent({ name: 'UserEntriesView' }).exists()).toBe(true)
  })
})
