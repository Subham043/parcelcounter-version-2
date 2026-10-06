import Account from "./Account";
import Password from "./Password";

function Profile() {
  return (
    <div className="space-y-6 pt-5">
      <Account />
      <Password />
    </div>
  );
}

export default Profile;
