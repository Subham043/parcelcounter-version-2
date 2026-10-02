

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

export type ChargeType = {
    id: number;
    name: string;
    slug: string;
    is_percentage: boolean;
    value: number;
    include_charges_for_cart_price_below: number | null;
    is_active: boolean;
    user_id: number;
    created_at: string;
    updated_at: string;
}

export type DeliverySlotType = {
    id: number;
    name: string;
    is_cod_allowed: boolean;
    start_time: string;
    end_time: string;
    is_active: boolean;
    user_id: number;
    created_at: string;
    updated_at: string;
}

export type FeatureType = {
    id: number;
    title: string;
    description: string;
    image: string;
    image_url: string;
    is_active: boolean;
    user_id: number;
    created_at: string;
    updated_at: string;
}


export type AxiosErrorResponseType = {
    message: string;
    errors?: Record<string, string[]>;
};

export type PaginationLinkType = {
    first: string | null;
    next: string | null;
    last: string | null;
    prev: string | null;
};

export type PaginationMetaType = {
    current_page: number;
    from: number;
    last_page: number;
    path: string;
    per_page: number;
    links: {
        active: boolean;
        label: string;
        url: string | null;
    }[];
    to: number;
    total: number;
};

export type PaginationType<T> = {
    data: T[];
    links: PaginationLinkType;
    meta: PaginationMetaType;
};

export type PaginationQueryType = {
    page?: number;
    total?: number;
    search?: string;
}

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