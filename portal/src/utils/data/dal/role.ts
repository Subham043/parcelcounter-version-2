import axios from "@/utils/axios";
import { api_routes } from "@/utils/routes/api_routes";
import type { PaginationType, RoleType } from "@/utils/types";
import type { GenericAbortSignal } from "axios";


export const getRolesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<RoleType>>(api_routes.role.paginate, { params, signal });
    return response.data;
}