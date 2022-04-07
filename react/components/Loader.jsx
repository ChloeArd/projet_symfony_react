import loader from "../../assets/images/waiting-texting.gif"

export const Loader = function () {

    return(
        <div className="Loader">
            <img src={loader} alt="En cours de chargement" />
        </div>
    )
}