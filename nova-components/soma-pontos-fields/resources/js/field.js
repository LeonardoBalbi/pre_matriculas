import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-soma-pontos-fields', IndexField)
  app.component('detail-soma-pontos-fields', DetailField)
  app.component('form-soma-pontos-fields', FormField)
})
