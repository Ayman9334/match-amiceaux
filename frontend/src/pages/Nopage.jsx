import { useEffect } from "react";
import { Link } from "react-router-dom"

const Nopage = () => {
    useEffect(() => {
        window.effectCommands();
    },[])
    return (
        <div>
            <br />
            <hr />
            <Link to="/">return home</Link>
            <hr />
        </div>
    )
}

export default Nopage
