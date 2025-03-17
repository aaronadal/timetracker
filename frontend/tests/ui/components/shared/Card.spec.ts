import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import Card from '../../../../src/ui/components/shared/Card.vue'

describe('Card', () => {
  it('renders content slot', () => {
    const wrapper = mount(Card, {
      slots: {
        default: 'Card content'
      }
    })

    expect(wrapper.find('.card').exists()).toBe(true)
    expect(wrapper.find('.card-content').text()).toBe('Card content')
  })

  it('does not render header when slot is not provided', () => {
    const wrapper = mount(Card, {
      slots: {
        default: 'Card content'
      }
    })

    expect(wrapper.find('.header').exists()).toBe(false)
  })

  it('renders header slot when provided', () => {
    const wrapper = mount(Card, {
      slots: {
        header: 'Card header',
        default: 'Card content',
      }
    })

    expect(wrapper.find('.header').exists()).toBe(true)
    expect(wrapper.find('.header').text()).toBe('Card header')
  })

  it('does not render footer when slot is not provided', () => {
    const wrapper = mount(Card, {
      slots: {
        default: 'Card content'
      }
    })

    expect(wrapper.find('.footer').exists()).toBe(false)
  })

  it('renders footer slot when provided', () => {
    const wrapper = mount(Card, {
      slots: {
        footer: 'Card footer',
        default: 'Card content'
      }
    })

    expect(wrapper.find('.footer').exists()).toBe(true)
    expect(wrapper.find('.footer').text()).toBe('Card footer')
  })
})
