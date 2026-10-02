import { Badge } from "../ui/badge";
import { cn } from "@/utils/lib/utils";

function ActiveBadge({ value }: { value: boolean }) {
  return (
    <Badge
      variant="default"
      className={cn(
        value ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800",
      )}
    >
      {value ? "Yes" : "No"}
    </Badge>
  );
}

export default ActiveBadge;
