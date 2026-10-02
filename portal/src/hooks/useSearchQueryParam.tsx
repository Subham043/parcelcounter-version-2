import { useSearchParams } from "react-router";
import { useCallback } from "react";
import { PAGEKEY } from "./usePaginationQueryParam";
import { QueryInitialPageParam } from "@/utils/constants/query";
import { useDebouncedCallback } from "@tanstack/react-pacer/debouncer";

type SearchQueryParamHookType = () => {
  search: string;
  setSearch: (value: string) => void;
};

export const SEARCHKEY = "filter[search]";

export const useSearchQueryParam: SearchQueryParamHookType = () => {
  const [searchParams, setSearchParams] = useSearchParams();

  const search = searchParams.get(SEARCHKEY) ?? "";

  const setSearch = useCallback(
    (value: string) => {
      setSearchParams(
        (prev) => {
          const params = new URLSearchParams(prev);
          value ? params.set(SEARCHKEY, value) : params.delete(SEARCHKEY);
          if (params.has(PAGEKEY)) {
            params.set(PAGEKEY, String(QueryInitialPageParam));
          }
          return params;
        },
        { replace: true },
      ); // 👈 prevent history spam
    },
    [setSearchParams],
  );

  const debouncedSetSearch = useDebouncedCallback(setSearch, {
    wait: 500,
  });

  return {
    search,
    setSearch: debouncedSetSearch,
  };
};
