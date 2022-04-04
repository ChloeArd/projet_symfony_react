import './Categories.css';

import {useState, useEffect} from 'react';

export const Categories = function ({setCategory}) {
    const [categories, setCategories] = useState([]);
    useEffect(() => {

        //Avec XHR
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/categories');
        xhr.responseType = 'json';
        xhr.onload = () => {setCategories(xhr.response)};
        xhr.send();


        //Fetch et les promesses
        /**fetch('/api/categories')
            .then(response => {
                if (response.ok) {
                    response.json()
                        .then(data => setCategories(data))
                }
            })
*/

        /**
        async function getCategories() {
            const data = await fetch('/api/categories');
            setCategories(await data.json());
        }
        getCategories().catch(() => console.log("Erreur de récupération de catégories !"));
         */
    }, []);

    return (
        <div className="Categories">
            <select onChange={(e) => setCategory(parseInt(e.target.value))}>
                {categories.map(category => <option value={category.id} key={category.id}>{category.name.charAt(0).toUpperCase() + category.name.slice(1)}</option>)}
            </select>
        </div>
    );
}