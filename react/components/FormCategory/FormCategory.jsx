import "./FormCategory.css";
import {useForm} from "react-hook-form";

export const FormCategory = function () {

    const {register, formState: {errors}, handleSubmit} = useForm();

    function onSubmit(formData) {
        console.log(formData);
    }

    return(
        <div className="category-add-form">
            <form onSubmit={handleSubmit(onSubmit)}>
                <h1>Ajouter une catégorie</h1>
                <label htmlFor="name_category">Nom de la catégorie</label>
                <input type="text" {...register('name', {required: true})}/>
                <p className="red">{errors.name?.type === 'required' && "Le nom est requis"}</p>
                <input type="submit" value="Ajouter"/>
            </form>
        </div>
    );
}