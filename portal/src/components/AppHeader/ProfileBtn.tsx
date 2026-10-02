import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "../ui/dropdown-menu";
import { Button } from "../ui/button";
import { Avatar, AvatarFallback } from "../ui/avatar";
import { useAuthStore } from "@/stores/auth.store";
import { useCallback, useMemo } from "react";
import { getNameInitials } from "@/utils/helper";
import { BadgeCheck, ChevronDown, Loader2, LogOut } from "lucide-react";
import { Link } from "react-router";
import { page_routes } from "@/utils/routes/page_routes";
import { useLogoutMutation } from "@/utils/data/mutation/profile";

const LogoutBtn = () => {
  const logoutMutate = useLogoutMutation();

  const onLogoutHandler = useCallback(async () => {
    await logoutMutate.mutateAsync();
  }, [logoutMutate.mutateAsync]);
  return (
    <DropdownMenuItem
      onClick={onLogoutHandler}
      disabled={logoutMutate.isPending}
      className="cursor-pointer"
    >
      {logoutMutate.isPending ? (
        <Loader2 className="animate-spin" />
      ) : (
        <LogOut />
      )}
      Log out
    </DropdownMenuItem>
  );
};

function ProfileBtn() {
  const authUser = useAuthStore((state) => state.authUser);
  const name = useMemo(() => {
    return authUser ? authUser.name : "User";
  }, [authUser]);
  const email = useMemo(() => {
    return authUser ? authUser.email : undefined;
  }, [authUser]);
  const initials = useMemo(() => {
    return getNameInitials(name);
  }, [name]);
  return (
    <DropdownMenu>
      <DropdownMenuTrigger
        className="transition-colors cursor-pointer"
        render={<Button variant="ghost" className="h-auto rounded-md" />}
      >
        <div className="flex items-center gap-2 py-1 ">
          <Avatar className="h-8 w-8 rounded-lg">
            <AvatarFallback className="rounded-lg">{initials}</AvatarFallback>
          </Avatar>
          <div className="grid flex-1 text-left text-sm leading-tight">
            <span className="truncate font-medium">{name}</span>
          </div>
          <ChevronDown className="ml-auto size-4" />
        </div>
      </DropdownMenuTrigger>
      <DropdownMenuContent
        className="w-(--radix-dropdown-menu-trigger-width) min-w-56 rounded-lg"
        side="bottom"
        align="end"
        sideOffset={4}
      >
        <DropdownMenuGroup>
          <DropdownMenuLabel>
            <div className="px-1">
              <p className="text-sm font-medium text-gray-800 truncate">
                {name}
              </p>
              {email && (
                <p className="text-xs text-gray-500 truncate">
                  {email.toLocaleLowerCase()}
                </p>
              )}
            </div>
          </DropdownMenuLabel>
        </DropdownMenuGroup>
        <DropdownMenuSeparator />
        <DropdownMenuGroup>
          <DropdownMenuItem render={<Link to={page_routes.profile.link} />}>
            <BadgeCheck />
            Profile
          </DropdownMenuItem>
          <LogoutBtn />
        </DropdownMenuGroup>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default ProfileBtn;
