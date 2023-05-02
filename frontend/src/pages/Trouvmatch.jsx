import { useEffect } from "react";
import MatchsTable from "../comps/matchsTable";
import Galerie from "../comps/Galerie";

const Trouvmatch = () => {
    useEffect(() => {
        window.effectCommands();
    },[])
    return (
        <>
            <MatchsTable />
            <Galerie />
        </>
    )
}

export default Trouvmatch
