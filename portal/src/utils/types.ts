

export type AuthType = {
    id: number;
    name: string;
    email?: string;
    phone: string;
    verified: "VERIFIED" | "VERIFICATION PENDING";
    email_verified_at: string | null;
    phone_verified_at: string | null;
    is_blocked: boolean;
    roles: AvailableRoles[];
    created_at: string;
    updated_at: string;
}

export type ProfileType = AuthType;

export type ModalProps<T> =
    | {
        show: false;
    }
    | ({
        show: true;
    } & T);

export type ExtendedModalProps<T> =
    | {
        show: boolean;
        type: "create";
    }
    | ({
        show: boolean;
        type: "update";
    } & T);

export type AvailableRoles =
    | 'Super-Admin'
    | 'Staff'
    | 'Content Manager'
    | 'Inventory Manager'
    | 'Warehouse Manager'
    | 'Delivery Agent'
    | 'User'
    | 'App Promoter'
    | 'Reward Riders'
    | 'Referral Rockstars';