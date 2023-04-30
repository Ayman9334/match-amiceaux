import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom';
import LayoutPrincipal from './templates/LayoutPrincipal';
import Acceuil from './pages/Acceuil';
import Inscription from './pages/inscription';
import Trouvmatch from './pages/trouvmatch';


function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<LayoutPrincipal />}>
          <Route index element={<Acceuil/>} />
          <Route path='/inscription' element={<Inscription />} />
          <Route path='/trouve-match' element={<Trouvmatch />} />
        </Route>
        <Route path='*' element={<Navigate to='/' />}/>
      </Routes>
    </BrowserRouter>
  )
}

export default App
