import "./FormProduct.css";
import {useForm} from "react-hook-form";

export const FormProduct = function ({categories}) {

    const {register, formState: {errors}, handleSubmit} = useForm();

    function onSubmit(formData) {
        console.log(formData);
    }

    return(
        <div className="product-add-form">
            <form onSubmit={handleSubmit(onSubmit)}>
                <h1>Ajouter un produit</h1>
                <label htmlFor="name_product">Nom du produit</label>
                <input type="text" {...register('name', {required: true})}/>
                <p className="red">{errors.name?.type === 'required' && "Le nom est requis"}</p>
                <label htmlFor="image_product">Image du produit</label>
                <input type="url" {...register('image', {required: true})}/>
                <p className="red">{errors.image?.type === 'required' && "L'image est requise"}</p>
                <label htmlFor="description_product">Description</label>
                <textarea rows="20" cols="20" {...register('description', {required: true, minLength: 10})}/>
                <p className="red">{errors.description?.type === 'required' && "La description est requise"}</p>
                <label htmlFor="price_product">Prix du produit</label>
                <input type="number" {...register('price', {required: true})}/>
                <p className="red">{errors.price?.type === 'required' && "Le prix est requis"}</p>
                <label htmlFor="stock_product">Stock</label>
                <input type="number" {...register('stock', {required: true})}/>
                <p className="red">{errors.stock?.type === 'required' && "Le stock est requis"}</p>
                <label htmlFor="category_product">Catégorie</label>
                <select {...register("category", {required: true})}>
                    {categories.map(category => <option value={category.id}>{category.name}</option>)}
                </select>
                <input type="submit" value="Ajouter"/>
            </form>
        </div>
    );
}