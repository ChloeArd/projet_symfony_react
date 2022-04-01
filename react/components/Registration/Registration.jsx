import "./Registration.css";
import {useForm} from "react-hook-form";

export const Registration = function () {

    const {register, formState: {errors}, handleSubmit} = useForm();

    function onSubmit(formData) {
        console.log(formData);
    }

    return(
        <div className="registration-form">
            <form onSubmit={handleSubmit(onSubmit)}>
                <h1>Inscription</h1>
                <label htmlFor="firstname_user">Prénom</label>
                <input type="text" {...register('firstname', {required: true, max: 20})}/>
                <p className="red">{errors.firstname?.type === 'required' && "Le prénom est requis"}</p>
                <label htmlFor="lastname_user">Nom de famille</label>
                <input type="text" {...register('lastname', {required: true, max: 20})}/>
                <p className="red">{errors.lastname?.type === 'required' && "Le nom de famille est requis"}</p>
                <label htmlFor="email_user">Email</label>
                <input type="email" {...register('email', {required: true})}/>
                <p className="red">{errors.email?.type === 'required' && "L'email est requise"}</p>
                <label htmlFor="password_user">Mot de passe</label>
                <input type="password" {...register('password', {required: true})}/>
                <p className="red">{errors.password?.type === 'required' && "Le mot de passe est requis"}</p>
                <label htmlFor="repeat_password_user">Répétition du mot de passe</label>
                <input type="password" {...register('repeatPassword', {required: true})}/>
                <p className="red">{errors.repeatPassword?.type === 'required' && "La répétition du mot de passe est requis"}</p>
                <input type="submit" value="S'inscrire"/>
            </form>
        </div>
    );
}