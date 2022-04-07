import {useState, useEffect} from 'react';
import styled from "styled-components";

export const Categories = function ({setCategory}) {
    const [categories, setCategories] = useState([]);
    const defaultCategory = {id: 0, name: "Tout"};

    useEffect(() => {
        //Avec XHR
        /*const xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/categories');
        xhr.responseType = 'json';
        xhr.onload = () => {setCategories(xhr.response)};
        xhr.send();*/

        //Fetch et les promesses
        /**fetch('/api/categories')
            .then(response => {
                if (response.ok) {
                    response.json()
                        .then(data => setCategories(data))
                }
            })
        */

        async function getCategories() {
            const response = await fetch('/api/categories');
            const data = await response.json();
            setCategories([defaultCategory, ...data]);
        }
        getCategories().catch(() => console.log("Erreur de récupération de catégories !"));

    }, []);

    return (
        <div className="Categories">
            <SelectCategories onChange={(e) => setCategory(parseInt(e.target.value))}>
                {categories.map(category => <option value={category.id} key={category.id}>{category.name.charAt(0).toUpperCase() + category.name.slice(1)}</option>)}
            </SelectCategories>
        </div>
    );
}

const SelectCategories = styled.select`
    border-radius: 10px;
    border: 1px solid #F2F2F3;
    padding: 15px;
    width: 40%;
    margin: 15px;
    font-size: 20px;
    box-shadow: rgba(0, 0, 0, 0.15) 0 5px 15px 0;
`;