import { useImpersonationStore } from "@/store/useImpersonationStore";
import { useExitImpersonationMutation } from "@/utils/data/mutation/profile";
import { toTitleCase } from "@/utils/helper";
import { UserRoundArrowLeft } from "lucide-react";
import { useCallback } from "react";

function ImpersonateExitBtn() {
    const impersonationUser = useImpersonationStore((s) => s.impersonationUser);
    const exitImpersonationMutate = useExitImpersonationMutation();

    const onExitImpersonateHandler = useCallback(async () => {
        await exitImpersonationMutate.mutateAsync();
    }, [exitImpersonationMutate.mutateAsync]);

    if (impersonationUser === null) return null;
    return (
        <button
            className="hidden md:flex items-center gap-1.5 px-3 py-1.5 text-sm text-red-600 border border-red-300 rounded-md hover:bg-red-50 transition-colors"
            onClick={onExitImpersonateHandler}
        >
            <UserRoundArrowLeft size={15} />
            {toTitleCase(
                impersonationUser
                    ? `${impersonationUser.fname} ${impersonationUser.lname}`
                    : "User",
            )}
        </button>
    );
}

export default ImpersonateExitBtn;
