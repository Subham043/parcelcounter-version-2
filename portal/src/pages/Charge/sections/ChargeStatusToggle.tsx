import { useChargeToggleStatusMutation } from "@/utils/data/mutation/charge";
import { Button } from "@/components/ui/button";
import { Spinner } from "@/components/ui/spinner";
import { Power, PowerOff } from "lucide-react";
import { useCallback } from "react";

function ChargeStatusToggle({
  id,
  isActive,
}: {
  id: number;
  isActive: boolean;
}) {
  const chargeToggleStatusMutation = useChargeToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await chargeToggleStatusMutation.mutateAsync(undefined);
  }, [chargeToggleStatusMutation]);

  return (
    <Button
      type="button"
      size="xs"
      variant="ghost"
      onClick={onToggle}
      disabled={chargeToggleStatusMutation.isPending}
      className={
        isActive
          ? "gap-1.5 rounded-full bg-emerald-50 px-2.5 text-emerald-700 hover:bg-emerald-100"
          : "gap-1.5 rounded-full bg-red-50 px-2.5 text-red-600 hover:bg-red-100"
      }
    >
      {chargeToggleStatusMutation.isPending ? (
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

export default ChargeStatusToggle;
