import { BrowserRouter, Route, Routes } from 'react-router-dom';
import LayoutPrincipal from './templates/LayoutPrincipal';
import Acceuil from './pages/Acceuil';
import Inscription from './pages/Inscription';
import Trouvmatch from './pages/trouvmatch';
import Nopage from './pages/Nopage';
import CreeMatch from './pages/CreeMatch';


function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<LayoutPrincipal />}>
          <Route index element={<Acceuil/>} />
          <Route path='/inscription' element={<Inscription />} />
          <Route path='/trouve-match' element={<Trouvmatch />} />
          <Route path='/cree-match' element={<CreeMatch />} />
        </Route>
        <Route path='*' element={<Nopage />}/>
      </Routes>
    </BrowserRouter>
  )
}

export default App
