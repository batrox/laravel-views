import feather from 'feather-icons'

try {
  const setUpUiLibraries = () => {
    feather.replace()
  }

  document.addEventListener("DOMContentLoaded", () => {
    setUpUiLibraries()

    Livewire.hook('morph.updated',  ({ el, component }) => {
        queueMicrotask(() => {
          // Equivalent of 'message.processed'
          setUpUiLibraries()
        })
    })

    Livewire.hook('morph.added',  ({ el, component }) => {
      queueMicrotask(() => {
        // Equivalent of 'message.processed'
        setUpUiLibraries()
      })
    })
  })
} catch (error) {
  throw new Error(error)
}
