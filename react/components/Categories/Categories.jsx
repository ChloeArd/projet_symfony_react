import './Categories.css';

export const Categories = function ({setCategory, categories}) {

    return (
        <div className="Categories">
            <select onChange={(e) => setCategory(parseInt(e.target.value))}>
                {categories.map(category => <option value={category.id} key={category.id}>{category.name}</option>)}
            </select>
        </div>
    );
}