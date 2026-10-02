import { Button } from "@/components/ui/button";
import { Spinner } from "@/components/ui/spinner";
import { Power, PowerOff } from "lucide-react";

function StatusToggleBadge({
  isActive,
  onToggle,
  loading,
}: {
  isActive: boolean;
  onToggle: () => Promise<void>;
  loading: boolean;
}) {
  return (
    <Button
      type="button"
      size="xs"
      variant="ghost"
      onClick={onToggle}
      disabled={loading}
      className={
        isActive
          ? "gap-1.5 rounded-full bg-emerald-50 px-2.5 text-emerald-700 hover:bg-emerald-100"
          : "gap-1.5 rounded-full bg-red-50 px-2.5 text-red-600 hover:bg-red-100"
      }
    >
      {loading ? (
        <Spinner className="size-3.5" />
      ) : isActive ? (
        <PowerOff className="size-3.5" />
      ) : (
        <Power className="size-3.5" />
      )}

      {isActive ? "Yes" : "No"}
    </Button>
  );
}

export default StatusToggleBadge;
