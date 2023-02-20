
import { useState } from 'react';
import './App.css';
import Button from './components/Button';


function App() {
  const [number,setNumber] = useState(0);
  // const [name,setName] = useState('');
  // const [tahunLahir,setTahunLahir] = useState('');
  // const [usia,setUsia] = useState('');

const [form, setForm] = useState({
  name: '',
  usia: '',
  tahunLahir: '', 
});
// console.log(number);
  const klik = () => {
    setNumber (number +1 );   
  };

  const handleSubmit = () => { 
    setForm ({...form,usia: 2023 - form.tahunLahir });
  };

  const handleChange = (e) => {
    setForm({...form, [e.target.name]: e.target.value});
  }


    
  return (
    <>
      <h1>Counter age</h1>
      <p>Nilai counter saat ini {number}</p>
      <Button onClick={klik}>Click Me</Button>

      <hr />

      <h1>Aplikasi input data diri</h1>
      Name : {' '} 
      <input 
          type='text' 
          value={form.name} 
          name='name'
          onChange={handleChange} /> <br/><br/>
      
      Tahun Lahir : {' '} 
      <input 
          type='text' 
          value={form.tahunLahir} 
          name='tahunLahir'
          onChange={handleChange}   
          />

          <br/><br/>

      Umur Saya : {form.usia} 
      <br/><br/>
      <Button onClick={handleSubmit}>Submit</Button>
    </>

  );
}

export default App;
