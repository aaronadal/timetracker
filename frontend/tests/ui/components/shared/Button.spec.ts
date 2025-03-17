import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import Button from '../../../../src/ui/components/shared/Button.vue'

describe('Button', () => {
  it('renders properly with primary type', () => {
    const wrapper = mount(Button, {
      props: {
        type: 'primary'
      },
      slots: {
        default: 'Text'
      }
    })

  
    expect(wrapper.text()).toContain('Text')
    expect(wrapper.classes()).toContain('button-primary')
  })

  it('renders properly with tertiary type', () => {
    const wrapper = mount(Button, {
      props: {
        type: 'tertiary'
      },
      slots: {
        default: 'Text'
      }
    })

    expect(wrapper.text()).toContain('Text')
    expect(wrapper.classes()).toContain('button-tertiary')
  })

  it('emits click event when clicked', async () => {
    const wrapper = mount(Button, {
      props: {
        type: 'primary'
      },
      slots: {
        default: 'Text'
      }
    })

    await wrapper.trigger('click')
    
    expect(wrapper.emitted()).toHaveProperty('click')
  })
}) 