
// import './App.css';
// import { Hello } from './Hello';
// import { Title } from './Title';
// import Button  from './components/Button';
// import Table from './components/Table';




// function App() {

// const users = [
// {
//   _id: 1,
//   name: 'Yohanes',
//   age: 21,
//   status: true,
// },
// {
//   _id: 2,
//   name: 'Zaun',
//   age: 23,
//   status: true,
// },
// {
//   _id: 3,
//   name: 'Abu',
//   age: 23,
//   status: true,
// },

// ];

// const isLogin = false;

//   return (
// <>
// <h1><Hello /></h1>

// <Title name = "irvan febriansyah" />
// <br/>
// <Title name = "majid" />

// <ul>
//   <li>Home</li>
//   <li>Users</li>
//   <li>{isLogin ? 'Sudah login' : 'Login'}</li>
// </ul>
// <Button onClick={() => alert('click save')}>Save</Button>
// <Table users = {users} />
// </>
//   );
// }

// export default App;

import React from 'react';
import { BrowserRouter, Route, Routes, } from 'react-router-dom';
import PageSignin from './pages/signin';
import './App.css';




function App() {
  return (
    <BrowserRouter>
      <Routes>
   
        <Route path='signin' element={<PageSignin />} />
       
      </Routes>
    </BrowserRouter>
  );

  
}

export default App;