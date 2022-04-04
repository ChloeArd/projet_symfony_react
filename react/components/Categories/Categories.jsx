import './Categories.css';

import {useState, useEffect} from 'react';

export const Categories = function ({setCategory}) {
    const [categories, setCategories] = useState([]);
    useEffect(() => {
        /**
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/categories');
        xhr.responseType = 'json';
        xhr.onload = () => xhr.status === 200 && setCategories(xhr.response);
        xhr.send();
         */

        fetch('/api/categories')
            .then(response => {
                if (response.ok) {
                    response.json()
                        .then(data => setCategories(data))
                }
            })
    }, []);

    return (
        <div className="Categories">
            <select onChange={(e) => setCategory(parseInt(e.target.value))}>
                {categories.map(category => <option value={category.id} key={category.id}>{category.name}</option>)}
            </select>
        </div>
    );
}