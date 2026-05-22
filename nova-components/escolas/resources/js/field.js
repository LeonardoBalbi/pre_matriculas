import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-escolas', IndexField)
  app.component('detail-escolas', DetailField)
  app.component('form-escolas', FormField)
})
