import { Outlet } from 'react-router-dom'
import NavigationBar from '../comps/NavigationBar'
import PiedPage from '../comps/PiedPage'
import Preloader from '../comps/Preloader'
import { useStateContext } from '../context/ContextProvider'


const LayoutPrincipal = () => {
  const {user, token, setUser, setToken, notification} = useStateContext();
  
  return (
    <>
        <Preloader />
        <NavigationBar />
        <Outlet />
        <PiedPage />
    </>
  )
}

export default LayoutPrincipal
