import { useState } from 'react';
import './ProfileCard.css';

function ProfileCard() {
  const [avatarPreview, setAvatarPreview] = useState('');

  const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
      const imageUrl = URL.createObjectURL(file);
      setAvatarPreview(imageUrl);
    }
  };

  return (
    <div className="profile-card">
      <h1>Моя визитка</h1>
      
      <div className="avatar-block">
        {avatarPreview ? (
          <img src={avatarPreview} alt="Аватар" className="avatar" />
        ) : (
          <div className="no-avatar">Нет аватара</div>
        )}
        <br />
        <input type="file" accept="image/*" onChange={handleImageUpload} />
      </div>

      <div className="info-block">
        <h2>Алфёров Сергей Сергеевич</h2>
        <p><strong>Специальность:</strong> Информатика и вычислительная техника</p>
        <p><strong>Группа:</strong> БИВТ-24-4</p>
        <p><strong>О себе:</strong> Студент 2 курса НИТУ МИСИС. Люблю кофе и программирование!</p>
      </div>
    </div>
  );
}

export default ProfileCard;