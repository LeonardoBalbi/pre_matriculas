import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-vagas-xp-fields', IndexField)
  app.component('detail-vagas-xp-fields', DetailField)
  app.component('form-vagas-xp-fields', FormField)
})
