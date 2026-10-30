import { DropdownMenuItem } from "../ui/dropdown-menu";
import { Pencil } from "lucide-react";

function EditButton({ onClick }: { onClick: () => void }) {
  return (
    <DropdownMenuItem onClick={onClick}>
      <Pencil /> Edit
    </DropdownMenuItem>
  );
}

export default EditButton;
