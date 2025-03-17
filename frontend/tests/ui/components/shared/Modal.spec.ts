import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import Modal from '../../../../src/ui/components/shared/Modal.vue'
import CloseIcon from '../../../../src/ui/components/shared/icons/CloseIcon.vue'

vi.mock('../../../../src/ui/components/shared/Card.vue', () => ({
  default: {
    name: 'Card',
    template: `<div class="card-mock">
        <div class="header-mock">
          <slot name="header" />
        </div>
        <div class="content-mock">
          <slot />
        </div>
        <div class="footer-mock">
          <slot name="footer" />
        </div>
      </div>
    `
  }
}))

describe('Modal', () => {
  it('renders the modal with content', () => {
    const wrapper = mount(Modal, {
      slots: {
        default: 'Modal content'
      }
    })

    expect(wrapper.find('.modal').exists()).toBe(true)
    expect(wrapper.find('.backdrop').exists()).toBe(true)
    expect(wrapper.find('.content-mock').text()).toBe('Modal content')
  })

  it('renders header slot content', () => {
    const wrapper = mount(Modal, {
      slots: {
        header: 'Modal header',
        default: 'Modal content'
      }
    })

    expect(wrapper.find('.header-mock').text()).toContain('Modal header')
  })

  it('renders footer slot content', () => {
    const wrapper = mount(Modal, {
      slots: {
        footer: 'Modal footer',
        default: 'Modal content'
      }
    })

    expect(wrapper.find('.footer-mock').text()).toBe('Modal footer')
  })

  it('emits dismiss event when close icon is clicked', async () => {
    const wrapper = mount(Modal)

    await wrapper.findComponent(CloseIcon).trigger('click')

    expect(wrapper.emitted()).toHaveProperty('dismiss')
  })
})
