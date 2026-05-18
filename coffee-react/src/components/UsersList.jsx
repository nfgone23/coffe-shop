import { useState, useEffect } from 'react';
import UserCard from './UserCard';
import './UsersList.css';

function UsersList() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetch('https://jsonplaceholder.typicode.com/users')
      .then((response) => response.json())
      .then((data) => {
        const firstThree = data.slice(0, 3);
        
        const russianStyleUsers = [
          {
            id: firstThree[0].id,
            name: 'Anna Smirnova',
            email: firstThree[0].email,
            phone: firstThree[0].phone
          },
          {
            id: firstThree[1].id,
            name: 'Ivan Petrov',
            email: firstThree[1].email,
            phone: firstThree[1].phone
          },
          {
            id: firstThree[2].id,
            name: 'Elena Vasilyeva',
            email: firstThree[2].email,
            phone: firstThree[2].phone
          }
        ];
        
        setUsers(russianStyleUsers);
        setLoading(false);
      })
      .catch(() => {
        setError('Ошибка загрузки данных');
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <div className="loading">Загрузка...</div>;
  }

  if (error) {
    return <div className="error">{error}</div>;
  }

  return (
    <div className="users-section">
      <h2>Наши постоянные клиенты</h2>
      <div className="users-list">
        {users.map((user) => (
          <UserCard key={user.id} user={user} />
        ))}
      </div>
    </div>
  );
}

export default UsersList;