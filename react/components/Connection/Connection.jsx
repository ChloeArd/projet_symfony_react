import "./Connection.css";
import {useForm} from "react-hook-form";

export const Connection = function () {

    const {register, formState: {errors}, handleSubmit} = useForm();

    function onSubmit(formData) {
        console.log(formData);
    }

    return(
        <div className="connection-form">
            <form onSubmit={handleSubmit(onSubmit)}>
                <h1>Connexion</h1>
                <label htmlFor="email_user">Email</label>
                <input type="email" {...register('email', {required: true})}/>
                <p className="red">{errors.email?.type === 'required' && "L'email est requise"}</p>
                <label htmlFor="password_user">Mot de passe</label>
                <input type="password" {...register('password', {required: true})}/>
                <p className="red">{errors.password?.type === 'required' && "Le mot de passe est requis"}</p>
                <input type="submit" value="Se connecter"/>
            </form>
        </div>
    );
}