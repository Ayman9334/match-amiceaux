import Carrousel from '../comps/Carrousel'
import News from '../comps/News'
import Galerie from '../comps/Galerie'
import { useEffect } from 'react'

const Acceuil = () => {
    useEffect(() => {
        window.effectCommands();
    })
    return (
        <>
            <Carrousel />
            <News />
            <Galerie />
        </>
    )
}

export default Acceuil
