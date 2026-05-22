import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-turmas', IndexField)
  app.component('detail-turmas', DetailField)
  app.component('form-turmas', FormField)
})
