<template>
          <Modal ref="new-item" :show="showModal">
            <div class="p-8 relative">
              <div
                class="absolute right-0 top-0 mr-2 mt-2 text-gray-700 hover:text-gray-900 cursor-pointer"
                @click="closeModal"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-x"
                >
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </div>
              <slot></slot>
            </div>
          </Modal>
</template>
<script>
import Modal from './../Jetstream/Modal'
export default {
    props : ['showItem'],
    components : {
        Modal
    },
    data() {
        return {
            showModal : this.showItem
        }
    },
    methods : {
        closeModal() {
            this.showModal = false;
        }

    }
    
}
</script>